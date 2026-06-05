# Implementation Plan: Add Gender and Date of Birth to User

**Date:** 05-06-2026
**Plan ID:** 1
**Status:** Draft
**Complexity:** Small

## 1. Requirements Analysis

### Functional Requirements
- [ ] Add `gender` (optional) field to the users table
- [ ] Add `date_of_birth` (optional) field to the users table
- [ ] Expose both fields in the account-settings form at `/member/{id}/account-settings`
- [ ] Persist values when the form is submitted via `PUT /member/{id}`
- [ ] Validate inputs server-side before saving

### Non-Functional Requirements
- [ ] Both fields must be nullable — no existing users are affected
- [ ] `date_of_birth` must not accept future dates
- [ ] `gender` must be constrained to a fixed set of values to avoid free-text inconsistency
- [ ] No breaking changes to existing form submissions

---

## 2. Architecture Review

### Existing Codebase Patterns
- User data is stored in the `users` table; new columns are added via dedicated migrations.
- The User model (`app/Models/User.php`) uses `$fillable` for mass-assignment protection and `$casts` for type coercion.
- Account settings are handled by `MemberController::update()` with inline `$request->validate()` (no dedicated Form Request class for this route yet).
- The Blade view `resources/views/user/account-settings.blade.php` renders the form; fields use `old('field', $user->field)` to repopulate after failed validation.

### Affected Areas
- `database/migrations/` — new migration file
- `app/Models/User.php` — `$fillable` and `$casts`
- `app/Http/Controllers/MemberController.php` — `update()` validation and save
- `resources/views/user/account-settings.blade.php` — two new form fields

### Reusable Components
- Existing `old()` / `@error` pattern already used throughout the view — reuse as-is.
- Existing `$user->update($validated)` call in `update()` will handle the new fields once they are in `$fillable`.

### Architecture Decision
- Store `gender` as a `VARCHAR` with an application-level enum constraint (validated via `in:` rule) rather than a MySQL ENUM, keeping schema changes reversible and DB-agnostic.
- Store `date_of_birth` as a `DATE` column and cast to Carbon in the model.

---

## 3. Step Breakdown

### Step 1: Database Migration
- **What:** Add nullable `gender` (string, max 30) and `date_of_birth` (date) columns to the `users` table.
- **Where:** `database/migrations/` — new file generated with `php artisan make:migration add_gender_and_date_of_birth_to_users_table`.
- **How:**
  ```php
  $table->string('gender', 30)->nullable()->after('bio');
  $table->date('date_of_birth')->nullable()->after('gender');
  ```
  Rollback drops both columns.
- **Test:** Run `php artisan migrate` and confirm columns appear in `DESCRIBE users;`.
- **Complexity:** Small

---

### Step 2: Update User Model
- **What:** Register `gender` and `date_of_birth` as fillable; cast `date_of_birth` to `date`.
- **Where:** `app/Models/User.php`
- **How:**
  - Add `'gender'` and `'date_of_birth'` to `$fillable`.
  - Add `'date_of_birth' => 'date'` to `$casts`.
- **Test:** `php artisan tinker` — create/update a User and verify the cast returns a Carbon instance for `date_of_birth`.
- **Complexity:** Small

---

### Step 3: Update Controller Validation
- **What:** Accept and validate `gender` and `date_of_birth` in `MemberController::update()`.
- **Where:** `app/Http/Controllers/MemberController.php` — `update()` method (line ~114).
- **How:** Extend the existing `$request->validate()` array:
  ```php
  'gender'        => 'nullable|string|in:male,female,non_binary,prefer_not_to_say',
  'date_of_birth' => 'nullable|date|before:today',
  ```
  The existing `$user->update($validated)` call handles persistence without further changes.
- **Test:** Submit the form with an invalid gender value and a future date — expect validation errors returned to the view.
- **Complexity:** Small

---

### Step 4: Update Account Settings View
- **What:** Add a Gender select and a Date of Birth date-picker to the form.
- **Where:** `resources/views/user/account-settings.blade.php` — inside the "Profile Details" section.
- **How:** Add two form groups following the existing pattern:
  ```blade
  {{-- Gender --}}
  <div class="mb-3">
      <label class="form-label fw-semibold" for="gender">Gender</label>
      <select name="gender" id="gender" class="form-select">
          <option value="">Prefer not to say</option>
          <option value="male"          {{ old('gender', $user->gender) === 'male'           ? 'selected' : '' }}>Male</option>
          <option value="female"        {{ old('gender', $user->gender) === 'female'         ? 'selected' : '' }}>Female</option>
          <option value="non_binary"    {{ old('gender', $user->gender) === 'non_binary'     ? 'selected' : '' }}>Non-binary</option>
          <option value="prefer_not_to_say" {{ old('gender', $user->gender) === 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
      </select>
      @error('gender') <div class="text-danger small">{{ $message }}</div> @enderror
  </div>

  {{-- Date of Birth --}}
  <div class="mb-3">
      <label class="form-label fw-semibold" for="date_of_birth">Date of Birth</label>
      <input type="date" name="date_of_birth" id="date_of_birth" class="form-control"
             value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}">
      @error('date_of_birth') <div class="text-danger small">{{ $message }}</div> @enderror
  </div>
  ```
- **Test:** Load `/member/{id}/account-settings`, fill both fields, submit — verify values persist and appear pre-filled on reload.
- **Complexity:** Small

---

## 4. Risk Assessment

### Risks
- **Existing users break on migration:** Both columns are nullable so existing rows are unaffected. Low risk.
- **`date_of_birth` formatting mismatch:** The `date` cast outputs Carbon; using `->format('Y-m-d')` ensures the HTML `<input type="date">` receives the correct ISO format.
- **Gender free-text injection:** Mitigated by the `in:` validation rule on the controller side — invalid values never reach the database.

### Mitigations
- Use `->nullable()` on both columns so the migration is safe to run against production data.
- The `?->format()` null-safe operator prevents errors for users with no `date_of_birth` set.

### Fallbacks
- If a free-text gender field is preferred over a fixed enum, the `in:` rule can be dropped and the select replaced with a plain text input without any model or migration changes.

---

## 5. Execution Checklist

- [ ] Step 1: Create and run migration — add `gender` and `date_of_birth` columns
- [ ] Step 2: Update `User` model — `$fillable` and `$casts`
- [ ] Step 3: Update `MemberController::update()` — add validation rules
- [ ] Step 4: Update `account-settings.blade.php` — add form fields
