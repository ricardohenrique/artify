# Implementation Plan: Fix Failing Tests

**Date:** 08-06-2026
**Plan ID:** 1
**Status:** Draft
**Complexity:** Medium

## 1. Requirements Analysis

### Functional Requirements
- [ ] All 14 pre-existing failures across `AuthenticationTest`, `RegistrationTest`, `ProfileTest`, `Settings/PasswordUpdateTest`, `Settings/ProfileUpdateTest` must pass.
- [ ] Authenticated and newly registered users must land on a deterministic, test-asserted destination (`route('dashboard')`).
- [ ] `/profile` (GET, PATCH, DELETE) OR `/settings/profile` + `/settings/password` must be reachable and behave per the test assertions (display, update profile, reset email verification on email change, delete account with password confirmation, password update with current-password check).

### Non-Functional Requirements
- [ ] No route-name collisions introduced (`password.update` currently risks a clash between `routes/auth.php` and `routes/settings.php`).
- [ ] Solution stays consistent with the project architecture: Blade frontend, thin controllers, business logic in Services.
- [ ] No production URIs broken; no regressions to currently passing tests (`MemberUpdateTest`, `PaintingListTest`, `MessageTest`, etc.).
- [ ] No Inertia/Vue artifacts left wired into a Blade application unless explicitly chosen.

## 2. Architecture Review

### Existing Codebase Patterns
- This repo is `laravel/vue-starter-kit` (Inertia + Vue) **partially converted to Blade**. CLAUDE.md and `.claude/rules/laravel.md` mandate Blade.
- Routes are split into domain files required from `routes/web.php`: `pages.php`, `paintings.php`, `artists.php`, `oauth.php`, `member.php`, `auth.php`. **`routes/settings.php` exists but is NOT required** in `web.php`.
- There are TWO parallel, conflicting profile stacks:
  - **Blade stack:** `app/Http/Controllers/ProfileController.php` (`edit`, `destroy` only — **no `update` method**), Blade views at `resources/views/profile/edit.blade.php` + partials. Partials post to `route('profile.update')`, which is not registered. No `/profile` routes registered anywhere.
  - **Inertia stack:** `app/Http/Controllers/Settings/ProfileController.php` + `Settings/PasswordController.php` render `Inertia::render('settings/...')`, registered only in the unwired `routes/settings.php`.
- Post-auth redirect logic is duplicated inline in `Auth/AuthenticatedSessionController@store` and `Auth/RegisteredUserController@store`, branching on `$user->user_type_id ?? $user->user_type` (business logic in controllers — violates the thin-controller rule).

### Affected Areas — Root Cause per failing test
1. **`RegistrationTest::test_new_users_can_register`** — Controller redirects to `route('member.profile', ...)`, but test asserts `route('dashboard')`. FAIL.
2. **`AuthenticationTest::test_users_can_authenticate_using_the_login_screen`** — `UserFactory` assigns random `user_type_id`; only type 3 goes to `dashboard`. Test asserts `route('dashboard')`. FAIL (flaky).
3. **`ProfileTest` (5 tests)** — `/profile` routes not registered → 404. `ProfileController` has no `update` action.
4. **`Settings/ProfileUpdateTest` (5 tests)** — `routes/settings.php` not required in `web.php` → 404.
5. **`Settings/PasswordUpdateTest` (2 tests)** — Same as above → 404.

### Reusable Components
- Existing Blade `ProfileController` (`edit`, `destroy`) + Blade views.
- Existing `App\Http\Requests\ProfileUpdateRequest`.
- Existing `route('dashboard')` from `routes/member.php`.

### Architecture Decision — Requires User Confirmation

Three options exist:

**Option A — Blade `/profile` stack only (recommended):**
Wire the Blade `/profile` stack, add the missing `update` action, register `/profile` routes, redirect post-auth to `route('dashboard')`. Delete the unused Inertia `Settings/*` controllers/requests/routes and the `Settings/*` tests.
- Pros: aligns with Blade architecture, removes dead code, single source of truth.
- Cons: post-auth UX changes (type-based redirect → `dashboard`). Needs product confirmation.

**Option B — Wire the Inertia `Settings/*` stack:**
Require `routes/settings.php` in `web.php`, keep Inertia controllers.
- Not recommended: keeps Inertia in a Blade-mandated app, retains duplicate stacks.

**Option C — Preserve type-based redirect, update auth tests:**
Keep controllers unchanged. Update `AuthenticationTest` and `RegistrationTest` to set `user_type` and assert the correct member route. Register `/profile` and fix `ProfileController`.
- Pros: no UX change. Cons: auth tests become less generic.

**Decision: Option C for Steps 1–2, Option A for Steps 3–5.** Type-based post-auth redirect is a product requirement — auth controllers stay unchanged. Auth tests are updated to force `user_type` and assert the correct member route. The dead Inertia Settings stack is still removed (Blade mandate).

## 3. Step Breakdown

### Step 1: Fix auth tests to match type-based redirect (Option C)
- **What:** Update auth tests to force `user_type` and assert the route the controller actually redirects to.
- **Where:** `tests/Feature/Auth/AuthenticationTest.php`, `tests/Feature/Auth/RegistrationTest.php`.
- **How:** In `AuthenticationTest`, create the user with a specific `user_type` (e.g., default factory type) and assert the matching redirect destination. In `RegistrationTest`, assert `route('member.profile', $user)` or `route('dashboard')` based on what `RegisteredUserController` actually does for the factory's default type. Do not change the controllers.
- **Test:** `AuthenticationTest::test_users_can_authenticate_using_the_login_screen` and `RegistrationTest::test_new_users_can_register` green.
- **Complexity:** Small

### Step 2: Complete the Blade profile stack and register `/profile` routes
- **What:** Add the missing `update` action; register `GET/PATCH/DELETE /profile`.
- **Where:** `app/Http/Controllers/ProfileController.php`, a new profile route group required from `routes/web.php`.
- **How:** `update` fills validated input, nulls `email_verified_at` on email change, saves, redirects to `route('profile.edit')`. Register under `auth` middleware: `GET /profile` → `edit` (`profile.edit`), `PATCH /profile` → `update` (`profile.update`), `DELETE /profile` → `destroy` (`profile.destroy`). Keep `userDeletion` bag in `destroy`.
- **Test:** All 5 `ProfileTest` tests pass.
- **Complexity:** Medium

### Step 3: Resolve the `password.update` route-name collision
- **What:** Ensure only one route owns the name `password.update`.
- **Where:** `routes/auth.php` vs. `routes/settings.php`.
- **How:** Under Option A, `routes/settings.php` is removed in Step 4, eliminating the clash. Verify `auth.php`'s `password.update` and any Blade references still resolve correctly.
- **Test:** No `RouteNotFoundException`; profile password partial renders; full suite free of name-collision errors.
- **Complexity:** Small

### Step 4: Remove dead Inertia Settings stack (Option A only)
- **What:** Delete unused Inertia profile/settings code and its tests.
- **Where:** `app/Http/Controllers/Settings/ProfileController.php`, `Settings/PasswordController.php`, `app/Http/Requests/Settings/ProfileUpdateRequest.php`, `routes/settings.php`, `tests/Feature/Settings/ProfileUpdateTest.php`, `tests/Feature/Settings/PasswordUpdateTest.php`.
- **How:** Delete files; verify nothing references `Settings\*` classes or `routes/settings.php`.
- **Test:** Full suite green; grep confirms no dangling references.
- **Complexity:** Small

### Step 5: Full-suite verification
- **What:** Confirm all tests pass and document any UX behavior change.
- **Where:** `php artisan test`.
- **How:** Run full suite; verify 0 failures; add a short note to README if login/registration landing page changed.
- **Test:** `php artisan test` — entire suite green.
- **Complexity:** Small

## 4. Risk Assessment

### Risks
- **UX regression:** Forcing `route('dashboard')` post-auth changes where real users land. Product decision required.
- **Hidden Blade references:** Profile partials reference `route('profile.update')`, `route('verification.send')`, `route('password.update')` — all must resolve once `/profile` is wired.
- **Route-name collision:** `password.update` in both `auth.php` and `settings.php`; last-loaded wins silently.
- **Factory randomness:** `UserFactory` assigns a random `user_type_id`; auth tests can be flaky if type is not forced.
- **Deleting Settings tests** reduces coverage for any future Inertia work (acceptable in a Blade app).

### Mitigations
- Get explicit user approval on Option A vs. C and on the post-auth redirect destination before delegating.
- After Step 2, grep all Blade templates for `route('profile.` and `route('password.` to confirm every name is registered.
- Resolve the name collision by removing `settings.php` (Option A) — never leave both active.
- Extract redirect logic into a unit-tested Service so destination is deterministic.

### Fallbacks
- If type-based redirect must stay: do NOT change controllers; instead update `AuthenticationTest` and `RegistrationTest` to set `user_type` and assert the correct member route (Option C for Steps 1–2).
- If removing Inertia is too broad: fall back to Option B for the 7 Settings failures and revisit Inertia removal separately.

## 5. Execution Checklist

- [x] Pre-step: User confirmed Option C for auth tests (keep type-based redirect); Option A for profile stack cleanup.
- [ ] Step 1: Centralize post-auth redirect — `AuthenticationTest` + `RegistrationTest` green.
- [ ] Step 2: Add `ProfileController@update`; register `/profile` routes — `ProfileTest` 5/5 green.
- [ ] Step 3: Resolve `password.update` name collision; verify profile partials render.
- [ ] Step 4: Remove dead Inertia `Settings/*` files and tests (Option A).
- [ ] Step 5: `php artisan test` fully green; README updated if post-auth UX changed.
- [ ] code-reviewer approves before merging.
