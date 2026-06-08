# Implementation Plan: Refactor PaintingListController

**Date:** 08-06-2026  
**Plan ID:** 1  
**Status:** Draft  
**Complexity:** Medium

---

## 1. Requirements Analysis

### Functional Requirements
- [ ] Move all direct Eloquent queries out of `PaintingListController` into `PaintingRepository` and `CategoryRepository`.
- [ ] Move price-range parsing, sort resolution, and category fallback logic out of the controller into `PaintingService`.
- [ ] `PaintingListController` must only receive a request, call service methods, and return a view.
- [ ] Existing behaviour of the `explore` and `search` endpoints must remain identical.

### Non-Functional Requirements
- [ ] No regression in HTTP behaviour (routes, view data, pagination, query strings).
- [ ] Code follows existing project conventions: constructor DI, named exceptions, strict types.
- [ ] Feature tests cover the happy path and key edge cases for both endpoints.

---

## 2. Architecture Review

### Existing Codebase Patterns
- `PaintingService` + `PaintingRepository` already exist and follow the established pattern.
- `CategoryService` + `CategoryRepository` also exist; `CategoryRepository::getCategoryWithPaintingCount($quantity)` is similar but takes a limit — the explore page needs *all* categories.
- Services receive repositories via constructor injection; no interface bindings are registered yet (the container resolves concrete classes directly).

### Affected Areas
| File | Change |
|------|--------|
| `app/Http/Controllers/PaintingListController.php` | Slim down to thin controller |
| `app/Services/PaintingService.php` | Add `getExplorePaintings()` and `searchPaintings()` |
| `app/Repositories/PaintingRepository.php` | Add `getFilteredPaintings()` and `searchPaintings()` |
| `app/Services/CategoryService.php` | Add `getAllOrderedByPaintingCount()` and `findBySlug()` |
| `app/Repositories/CategoryRepository.php` | Add `getAllOrderedByPaintingCount()` and `findBySlug()` |
| `tests/Feature/PaintingListTest.php` | New feature test file |

### Reusable Components
- `PaintingRepository` eager-loading pattern (`with(['images', 'category'])->withCount('favoritedBy')`) is already used — replicate the same pattern for the new query methods.
- `CategoryRepository::getCategoryWithPaintingCount()` can be kept as-is; the new `getAllOrderedByPaintingCount()` is a no-limit variant.

### Architecture Decision
- Price parsing (`between-{from}-{to}` → `[float, float]`) is a **business rule** and belongs in `PaintingService`, not the repository. The repository receives already-parsed values (e.g. `?float $priceFrom, ?float $priceTo`).
- Sort resolution (mapping `'liked'`/`'cheap'`/`'newest'` to query clauses) is **query logic** and belongs in `PaintingRepository`.
- The fallback "independent artwork" category object is **presentation logic** — it stays in the controller as it is a view-only concern with no business meaning.

---

## 3. Step Breakdown

### Step 1: Extend `CategoryRepository` and `CategoryService`
- **What:** Add two new methods to support the explore page without touching existing ones.
- **Where:** `app/Repositories/CategoryRepository.php`, `app/Services/CategoryService.php`
- **How:**
  - `CategoryRepository::getAllOrderedByPaintingCount(): Collection` — same as existing but no `take()` limit.
  - `CategoryRepository::findBySlug(string $slug): ?Category` — wraps `Category::where('slug', $slug)->first()`. Returns `null` instead of throwing; the `firstOrFail` 404 behaviour will move to the service layer.
  - Mirror both methods on `CategoryService`.
- **Test:** No dedicated test needed at this step; will be covered by the feature test in Step 5.
- **Complexity:** Small

---

### Step 2: Add `getFilteredPaintings()` to `PaintingRepository`
- **What:** Encapsulate the explore query — category filter, price range filter, sort, and pagination — inside the repository.
- **Where:** `app/Repositories/PaintingRepository.php`
- **How:**
  ```php
  public function getFilteredPaintings(
      ?int $categoryId,
      ?float $priceFrom,
      ?float $priceTo,
      string $sort,
      int $perPage = 10
  ): LengthAwarePaginator
  ```
  - Start with `Painting::with(['images', 'category'])->withCount('favoritedBy')->where('is_draft', false)`.
  - Apply `where('category_id', $categoryId)` when `$categoryId` is not null.
  - Apply `whereBetween('price', [$priceFrom, $priceTo])` when both values are not null.
  - Resolve sort: `switch ($sort)` → `orderByDesc('favorited_by_count')` / `orderBy('price')` / `latest()`.
  - Return `$query->paginate($perPage)->withQueryString()`.
- **Test:** Covered by feature test in Step 5.
- **Complexity:** Small

---

### Step 3: Add `searchPaintings()` to `PaintingRepository`
- **What:** Encapsulate the search query inside the repository.
- **Where:** `app/Repositories/PaintingRepository.php`
- **How:**
  ```php
  public function searchPaintings(string $term, int $perPage = 10): LengthAwarePaginator
  ```
  - `Painting::with(['images', 'category'])->withCount('favoritedBy')->where('is_draft', false)`.
  - Apply `where(fn($q) => $q->where('title', 'like', "%{$term}%")->orWhere('description', 'like', "%{$term}%"))`.
  - Return `$query->latest()->paginate($perPage)`.
- **Test:** Covered by feature test in Step 5.
- **Complexity:** Small

---

### Step 4: Extend `PaintingService`
- **What:** Add two service methods that contain the business logic and delegate persistence to the repository.
- **Where:** `app/Services/PaintingService.php`
- **How:**
  - `getExplorePaintings(?int $categoryId, ?string $priceFilter, string $sort, int $perPage): LengthAwarePaginator`
    - Parses `$priceFilter` (`between-{from}-{to}` format) into `$priceFrom`/`$priceTo` floats. This is the only business rule: if the format is invalid, silently ignore the filter (no exception — it is a user-facing filter from a query string).
    - Delegates to `$this->paintingRepository->getFilteredPaintings(...)`.
  - `searchPaintings(string $term, int $perPage): LengthAwarePaginator`
    - Delegates directly to `$this->paintingRepository->searchPaintings($term, $perPage)`.
- **Test:** Unit test for `getExplorePaintings` price-parsing logic (valid range, invalid range, no filter).
- **Complexity:** Small

---

### Step 5: Refactor `PaintingListController`
- **What:** Replace all direct model queries and business logic with service calls.
- **Where:** `app/Http/Controllers/PaintingListController.php`
- **How:**
  - Inject `PaintingService` and `CategoryService` via constructor.
  - `explore`:
    1. `$categories = $this->categoryService->getAllOrderedByPaintingCount()`
    2. Resolve `$categoryId` — call `$this->categoryService->findBySlug($categorySlug)`, then `abort(404)` if not found and slug was provided.
    3. `$paintings = $this->paintingService->getExplorePaintings($categoryId, $price, $sort)`.
    4. Category fallback object stays in the controller (pure presentation concern).
  - `search`:
    1. `$paintings = $this->paintingService->searchPaintings($query)`.
  - Remove all `use App\Models\Painting` and `use App\Models\Category` imports.
- **Test:** Feature test for both endpoints (see Step 6).
- **Complexity:** Small

---

### Step 6: Add Feature Tests
- **What:** Cover both endpoints with HTTP-level feature tests.
- **Where:** `tests/Feature/PaintingListTest.php` (new file)
- **How:** Use `RefreshDatabase` + factories. Test cases:
  - `explore` returns 200 with paintings.
  - `explore` with a valid category slug filters correctly.
  - `explore` with an invalid category slug returns 404.
  - `explore` with a price filter returns only paintings in range.
  - `explore` with `?sort=liked` returns paintings sorted by favorites.
  - `search` with a matching term returns relevant paintings.
  - `search` with a non-matching term returns an empty list.
- **Test:** `php artisan test --filter PaintingListTest`
- **Complexity:** Medium

---

## 4. Risk Assessment

### Risks
1. **Price filter format change** — the `between-{from}-{to}` string is a query-string convention tied to the Blade view. Parsing is moved to the service but the format must stay the same.
2. **`firstOrFail` vs `abort(404)`** — the existing controller uses `firstOrFail()` which auto-aborts with 404. The new `findBySlug()` returns `null` and the controller calls `abort(404)`. Behaviour is identical, but this needs careful testing.
3. **`withQueryString()` on paginator** — must be called inside the repository on the paginator, not after it is returned, to preserve filter query params in pagination links.

### Mitigations
- Feature tests on the explore endpoint with category slug cover risk 1 and 2.
- The `withQueryString()` call is already inside the planned repository method signature.

### Fallbacks
- If the service layer grows complex, the price parsing can be extracted to a dedicated `PriceRangeFilter` value object.
- If future sorts are added, the `switch` in the repository can be replaced with a strategy map.

---

## 5. Execution Checklist

- [ ] Step 1: Add `getAllOrderedByPaintingCount()` and `findBySlug()` to `CategoryRepository` and `CategoryService`.
- [ ] Step 2: Add `getFilteredPaintings()` to `PaintingRepository`.
- [ ] Step 3: Add `searchPaintings()` to `PaintingRepository`.
- [ ] Step 4: Add `getExplorePaintings()` and `searchPaintings()` to `PaintingService`.
- [ ] Step 5: Refactor `PaintingListController` to use injected services only.
- [ ] Step 6: Write feature tests in `tests/Feature/PaintingListTest.php` and run full suite.
