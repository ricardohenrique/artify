# Implementation Plan: Organize Routes and Controllers

**Date:** 08-06-2026  
**Plan ID:** 1  
**Status:** Draft  
**Complexity:** Medium

---

## 1. Requirements Analysis

### Functional Requirements
- [ ] All existing URIs must remain identical (production constraint).
- [ ] Fix two duplicate route name bugs before any other change.
- [ ] Consolidate 5 single-method static-page controllers into one `Pages\StaticPageController`.
- [ ] Move OAuth controllers (`GoogleController`, `FacebookController`) into `Auth\Social\` subfolder.
- [ ] Move painting-related controllers (`PaintingListController`, `PaintingImageController`) into the existing `Paintings\` subfolder.
- [ ] Move `MemberController` into a `Member\` subfolder and `ArtistController` into an `Artists\` subfolder.
- [ ] Standardize route names: replace `item.*` with `painting.*` for authenticated painting management; fix camelCase names.
- [ ] Split the flat `routes/web.php` into domain-scoped route files.

### Non-Functional Requirements
- [ ] Every step leaves the application in a deployable state.
- [ ] All existing passing tests continue to pass after each step.
- [ ] Route name changes must be propagated to all blade templates and controller redirects that reference them.
- [ ] No URIs change — existing bookmarks, SEO, and external links remain valid.

---

## 2. Architecture Review

### Existing Codebase Patterns
- Controllers are plain classes; no interface contracts needed.
- Laravel resolves controllers by FQCN — moving a class to a subfolder only requires a namespace + `use` update.
- Route files are not yet split; a single `routes/web.php` handles everything.
- An `Auth/` subfolder already exists for scaffolded auth controllers — the same pattern will be extended to `Auth\Social\`.
- A `Paintings/` subfolder already exists (`PaintingController`) — sibling controllers belong there too.
- Static page controllers each contain exactly one method returning a single view — strong candidates for consolidation.

### Identified Bugs (fix before refactoring)

| # | Issue | Location |
|---|-------|----------|
| 1 | `member.profile` defined twice | `web.php` lines 46 and 48 — line 46 (`GET /member/{id}`) shadows line 48 (`GET /member/{id}/profile`) |
| 2 | `paintings.favorite` defined twice | `web.php` lines 36 and 68 — the POST route (line 68) silently overrides the GET route name (line 36) |

### Affected Areas
| File / Folder | Change |
|---|---|
| `routes/web.php` | Split into domain files; fix names |
| `routes/pages.php` | New |
| `routes/paintings.php` | New |
| `routes/artists.php` | New |
| `routes/oauth.php` | New |
| `routes/member.php` | New |
| `app/Http/Controllers/Pages/StaticPageController.php` | New (consolidates 5 controllers) |
| `app/Http/Controllers/AboutUsController.php` | Delete |
| `app/Http/Controllers/PrivacyPolicyController.php` | Delete |
| `app/Http/Controllers/TermsConditionsController.php` | Delete |
| `app/Http/Controllers/FAQController.php` | Delete |
| `app/Http/Controllers/HowArtifyWorksController.php` | Delete |
| `app/Http/Controllers/Auth/Social/GoogleController.php` | Move + namespace update |
| `app/Http/Controllers/Auth/Social/FacebookController.php` | Move + namespace update |
| `app/Http/Controllers/Paintings/PaintingListController.php` | Move + namespace update |
| `app/Http/Controllers/Paintings/PaintingImageController.php` | Move + namespace update |
| `app/Http/Controllers/Member/MemberController.php` | Move + namespace update |
| `app/Http/Controllers/Artists/ArtistController.php` | Move + namespace update |
| Blade templates and controllers referencing `item.*` / `member.updatePrivacy` route names | Update |

### Architecture Decision
- Prefer **one route file per domain** (pages, paintings, artists, oauth, member) included from `web.php` — this scales better than section comments in a single file and mirrors the existing `auth.php` pattern.
- Consolidate the 5 static-page controllers into `Pages\StaticPageController` — each method is a single `return view()` line; keeping five files adds no value.
- Keep `HomeController` separate — the home page has distinct concerns (aggregated data) and will grow differently from static copy pages.
- Route name changes must be global-searched across `resources/views/` and `app/` before committing each step.

---

## 3. Step Breakdown

### Step 1: Fix Duplicate Route Names
- **What:** Resolve the two naming bugs so no route name maps to more than one definition.
- **Where:** `routes/web.php`
- **How:**
  - Line 46 `GET /member/{id}` → rename from `member.profile` to `member.show`.
  - Line 36 `GET /paintings/favorite/{painting_slug}` → rename from `paintings.favorite` to `painting.favorite.page` (this is a public GET page distinct from the POST toggle at line 68).
  - Search `resources/views/` and `app/` for any `route('member.profile')` calls **that target the `/member/{id}` URI** and update them to `route('member.show', ...)`. Leave references that target `/member/{id}/profile` unchanged.
  - Search for `route('paintings.favorite')` usages and update to the correct name based on intent.
- **Test:** `php artisan route:list` shows no duplicate names. All existing tests pass.
- **Complexity:** Small

---

### Step 2: Move OAuth Controllers to `Auth\Social\`
- **What:** Relocate `GoogleController` and `FacebookController` under `Auth\Social\` to sit alongside the existing `Auth\` scaffolding.
- **Where:**
  - Create `app/Http/Controllers/Auth/Social/GoogleController.php`
  - Create `app/Http/Controllers/Auth/Social/FacebookController.php`
  - Delete originals from `app/Http/Controllers/`
  - Update `use` imports in `routes/web.php`
- **How:** Change namespace from `App\Http\Controllers` to `App\Http\Controllers\Auth\Social`. No logic changes.
- **Test:** `GET /auth/google` and `GET /auth/facebook` still redirect to OAuth providers. `php artisan test` passes.
- **Complexity:** Small

---

### Step 3: Consolidate Static Page Controllers into `Pages\StaticPageController`
- **What:** Replace 5 single-method controllers (`AboutUsController`, `PrivacyPolicyController`, `TermsConditionsController`, `FAQController`, `HowArtifyWorksController`) with a single `Pages\StaticPageController`.
- **Where:**
  - Create `app/Http/Controllers/Pages/StaticPageController.php`
  - Delete the 5 old controller files
  - Update `use` imports in `routes/web.php`
- **How:**
  ```php
  // App\Http\Controllers\Pages\StaticPageController
  public function aboutUs(): Response { return response()->view('about-us', [], 200); }
  public function privacyPolicy(): Response { return response()->view('privacy-policy', [], 200); }
  public function termsConditions(): Response { return response()->view('terms-conditions', [], 200); }
  public function faq(): Response { return response()->view('faq', [], 200); }
  public function howArtifyWorks(): Response { return response()->view('how-artify-works', [], 200); }
  ```
  Route names and URIs remain unchanged.
- **Test:** `GET /about-us`, `/privacy-policy`, `/terms-conditions`, `/frequently-asked-questions`, `/how-artify-works` all return 200.
- **Complexity:** Small

---

### Step 4: Move Painting Controllers to `Paintings\`
- **What:** Relocate `PaintingListController` and `PaintingImageController` to the existing `Paintings\` subfolder so all painting controllers live together.
- **Where:**
  - Move to `app/Http/Controllers/Paintings/PaintingListController.php`
  - Move to `app/Http/Controllers/Paintings/PaintingImageController.php`
  - Delete originals
  - Update `use` imports in `routes/web.php`
- **How:** Namespace change from `App\Http\Controllers` to `App\Http\Controllers\Paintings`. No logic changes.
- **Test:** `GET /independent-artists-paintings/independent-artwork`, `/search`, and painting detail pages return correct responses. `php artisan test` passes.
- **Complexity:** Small

---

### Step 5: Move Member and Artist Controllers to Domain Subfolders
- **What:** Relocate `MemberController` → `Member\` and `ArtistController` → `Artists\`.
- **Where:**
  - Create `app/Http/Controllers/Member/MemberController.php`
  - Create `app/Http/Controllers/Artists/ArtistController.php`
  - Delete originals
  - Update `use` imports in `routes/web.php`
- **How:** Namespace change only. No logic changes.
- **Test:** `GET /member/{id}/dashboard`, `GET /independent-artists`, `GET /independent-artists/{slug}` return correct responses.
- **Complexity:** Small

---

### Step 6: Standardize Route Names
- **What:** Replace opaque `item.*` names with `painting.*` for the authenticated painting management group; fix camelCase names to kebab-case.
- **Where:** `routes/web.php` and all references in `resources/views/` and `app/`.
- **How — name mapping:**

  | Old name | New name |
  |---|---|
  | `item.new` | `painting.new` |
  | `item.create` | `painting.create` |
  | `item.store` | `painting.store` |
  | `item.add` | `painting.add` |
  | `item.edit` | `painting.edit` |
  | `item.editPainting` | `painting.edit-details` |
  | `item.update` | `painting.update` |
  | `item.updatePainting` | `painting.update-details` |
  | `member.updatePrivacy` | `member.privacy.update` |

  Run a global search for each old name before replacing to catch every `route('...')`, `redirect()->route('...')`, and `@if(Route::is('...'))` usage.
- **Test:** `php artisan route:list` shows clean, consistent names. All `route()` calls in views resolve. `php artisan test` passes.
- **Complexity:** Small

---

### Step 7: Split `routes/web.php` into Domain Route Files
- **What:** Extract route groups into separate files and include them from `web.php`, following the existing `auth.php` pattern.
- **Where:**
  - Create `routes/pages.php`
  - Create `routes/paintings.php`
  - Create `routes/artists.php`
  - Create `routes/oauth.php`
  - Create `routes/member.php`
  - Rewrite `routes/web.php` to `require` each file
- **How — target structure of `routes/web.php`:**
  ```php
  Route::get('/', [HomeController::class, 'index'])->name('index');
  Route::get('/go/{slug}', [LinkController::class, 'redirect'])->name('link.redirect');

  require __DIR__.'/pages.php';
  require __DIR__.'/paintings.php';
  require __DIR__.'/artists.php';
  require __DIR__.'/oauth.php';
  require __DIR__.'/member.php';
  require __DIR__.'/auth.php';
  ```
  Each domain file imports only its own controllers and defines its own routes.
- **Test:** `php artisan route:list` shows all routes. Full test suite passes. Manual smoke test on each domain (pages, paintings, artists, OAuth redirect, member area).
- **Complexity:** Medium

---

## 4. Risk Assessment

### Risks
1. **Route name references in Blade** — `item.*` and `member.updatePrivacy` are very likely used in form `action` attributes and `href` links inside blade templates. A missed reference causes a silent `Route [x] not defined` exception at runtime.
2. **`member.profile` used in `GoogleController::callback()`** — the OAuth redirect calls `route('member.profile', ...)` which maps to `/member/{id}/profile` after Step 1. Verify the redirect intent matches the correct URI.
3. **Class move breaks autoloading in edge cases** — Composer's classmap cache can lag; `composer dump-autoload` must be run after every namespace change.
4. **`PaintingListController` was just refactored** — it now lives at `App\Http\Controllers\PaintingListController`; tests reference it by route (HTTP-level), so tests are not affected by the move.

### Mitigations
- Before each rename in Step 6, run: `grep -r "route('item\." resources/ app/` and `grep -r "route('member.updatePrivacy" resources/ app/` to find all usages.
- After Step 1, verify `GoogleController::callback()` redirects to the intended page.
- Run `composer dump-autoload` after each step that moves a class.
- Run `php artisan route:list` after every step to catch routing issues immediately.

### Fallbacks
- If a step introduces a regression, revert that step independently — each step is scoped to one concern and does not depend on the next.
- If route name changes are too risky to do at once, Step 6 can be deferred and the old names kept in the new file structure without harm.

---

## 5. Execution Checklist

- [ ] Step 1: Fix duplicate route names (`member.show`, `painting.favorite.page`) and update all references.
- [ ] Step 2: Move `GoogleController` + `FacebookController` to `Auth\Social\`; update `routes/web.php` imports.
- [ ] Step 3: Create `Pages\StaticPageController`; delete 5 old controllers; update `routes/web.php` imports.
- [ ] Step 4: Move `PaintingListController` + `PaintingImageController` to `Paintings\`; update imports.
- [ ] Step 5: Move `MemberController` → `Member\`, `ArtistController` → `Artists\`; update imports.
- [ ] Step 6: Replace `item.*` and camelCase route names; grep and update all `route()` usages.
- [ ] Step 7: Split `routes/web.php` into `pages.php`, `paintings.php`, `artists.php`, `oauth.php`, `member.php`.
