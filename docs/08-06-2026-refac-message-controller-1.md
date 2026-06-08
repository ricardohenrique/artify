# Implementation Plan: Refactoring MessageController

**Date:** 08-06-2026  
**Plan ID:** 1  
**Status:** Draft  
**Complexity:** Medium

---

## 1. Requirements Analysis

### Functional Requirements
- [ ] `MessageController::index` lists the authenticated user's conversations and optionally loads a selected conversation, preserving current view data (`conversations`, `selectedConversation`, `user`).
- [ ] `MessageController::show` displays a single conversation, restricted to the buyer or seller.
- [ ] `MessageController::store` validates input and persists a new message to a conversation, restricted to participants.
- [ ] `MessageController::ask` creates (or reuses) a conversation between a buyer and the painting's seller, preventing self-messaging.
- [ ] All existing routes and redirects must continue to behave identically (`messages.index`, `messages.store`, `messages.ask`, `member.messages`).

### Non-Functional Requirements
- [ ] Controller becomes thin: receives request, delegates to a service, returns a response. No queries, no direct model access, no authorization branching.
- [ ] All database access moves into repositories (only layer touching Eloquent).
- [ ] Business rules (participant check, self-message prevention, conversation creation) move into a service.
- [ ] Input validation moves into Form Request classes.
- [ ] Authorization handled via Form Request / Policy / named domain exception — not inline `abort(403)` in the controller.
- [ ] `declare(strict_types=1)`, constructor DI, typed parameters/returns throughout new code.
- [ ] No N+1 regressions; preserve existing eager loading.
- [ ] Feature tests cover happy path, edge cases, and authorization failures.

---

## 2. Architecture Review

### Existing Codebase Patterns
- Service + Repository pattern is established: `PaintingService`/`PaintingRepository`, `UserService`/`UserRepository`, `CategoryService`/`CategoryRepository`, `ArtistService`/`ArtistRepository`.
- Services use **constructor injection of concrete repositories**. No repository/service interfaces exist anywhere in the project, and `AppServiceProvider` registers no interface→implementation bindings. Eloquent is called directly inside repositories.
- Controllers that use services follow the `FavoriteController` style: `protected SomeService $service;` injected via constructor; methods resolve `auth()->user()` and delegate.
- Form Requests already exist (`Settings/ProfileUpdateRequest`) using `rules()` and `authorize()`.
- `app/Exceptions/` currently contains **no** domain exception classes — this will be the first.
- Models `Message` and `Conversation` already define the needed relationships (`conversation`, `sender`, `painting`, `buyer`, `seller`, `messages`). `Conversation::messages()` is ordered `latest()`.

### Affected Areas
| File | Change |
|------|--------|
| `app/Http/Controllers/MessageController.php` | Slim down to thin controller with constructor DI |
| `app/Services/MessageService.php` | New — owns message/conversation business logic |
| `app/Repositories/ConversationRepository.php` | New — all conversation/message queries |
| `app/Http/Requests/StoreMessageRequest.php` | New — validation + participant authorization for `store` |
| `app/Exceptions/CannotMessageSelfException.php` | New — domain exception for `ask` self-message rule |
| `app/Exceptions/NotConversationParticipantException.php` | New — domain exception for participant rule |
| `bootstrap/app.php` | Map domain exceptions to HTTP responses (403 / redirect) |
| `tests/Feature/MessageTest.php` | New feature test file |

### Reusable Components
- `Message` and `Conversation` models and their relationships — no changes required (verify only).
- `FavoriteController` as the DI/controller template.
- `PaintingRepository` / `UserRepository` as the repository template.
- `Settings/ProfileUpdateRequest` as the Form Request template.

### Architecture Decision
- **No interfaces introduced.** The project consistently injects concrete repositories and registers no bindings. Introducing interfaces only for messages would break consistency and add unused abstraction (YAGNI / KISS). Repositories remain concrete; revisit globally if the team decides to standardize on interfaces.
- **Authorization split:** participant validation for `store` lives in `StoreMessageRequest::authorize()` (HTTP concern, returns 403 automatically). The participant rule reused inside the service layer is enforced via a named domain exception (`NotConversationParticipantException`) so the rule is also protected when called outside HTTP. Self-message prevention in `ask` becomes `CannotMessageSelfException`, rendered as a redirect-back-with-error to preserve current UX.
- **`index`/`show` query logic** moves to `ConversationRepository`; the service composes the view-model data and the controller passes it to the view unchanged.
- **`firstOrCreate` for conversations** stays a single atomic call inside the repository to avoid duplicate conversations under concurrency.

---

## 3. Step Breakdown

### Step 1: ConversationRepository
- **What:** New `ConversationRepository` encapsulating all conversation/message queries currently inline in the controller.
- **Where:** `app/Repositories/ConversationRepository.php`.
- **How:** Methods: `getUserConversations(int $userId): Collection` (buyer or seller, eager-load `painting` + latest message, ordered by `updated_at`); `findParticipantConversationOrFail(int $conversationId, int $userId): Conversation` (with `messages.sender`, `painting`, scoped to participant); `findWithParticipants(int $conversationId): Conversation` (with `buyer`, `seller`); `findOrCreate(int $paintingId, int $buyerId, int $sellerId): Conversation`; `addMessage(Conversation $conversation, int $senderId, string $content): Message`. Preserve existing eager-loading exactly. `declare(strict_types=1)`, typed signatures.
- **Test:** Unit/integration test with factories: returns only participant conversations, `findOrCreate` reuses an existing row, `addMessage` persists with correct `sender_id`/`conversation_id`.
- **Complexity:** Medium

### Step 2: Domain exceptions
- **What:** `CannotMessageSelfException` and `NotConversationParticipantException`.
- **Where:** `app/Exceptions/`.
- **How:** Extend a domain base or `\DomainException`; meaningful messages; no framework coupling. Suffix `Exception` per conventions.
- **Test:** Covered indirectly via service tests in Step 3 (assert thrown).
- **Complexity:** Small

### Step 3: MessageService
- **What:** New `MessageService` owning all message/conversation business rules.
- **Where:** `app/Services/MessageService.php`.
- **How:** Constructor-inject `ConversationRepository`. Methods: `getInboxData(User $user)` (returns conversations + loaded user counts/relations as today); `getSelectedConversation(int $conversationId, User $user): Conversation`; `getConversationForUser(Conversation $conversation, User $user): Conversation` (throws `NotConversationParticipantException` if not buyer/seller); `sendMessage(int $conversationId, User $user, string $content): Message` (load participants, enforce participant rule, delegate persistence); `startConversation(Painting $painting, User $user): Conversation` (throw `CannotMessageSelfException` if buyer == seller, else `findOrCreate`). User eager-load/`withCount` from `index` moves here — never Eloquent inline in the service; route the user query through `UserRepository`/`ConversationRepository`.
- **Test:** Unit tests: send happy path, non-participant throws, self-message throws, `startConversation` reuses existing conversation.
- **Complexity:** Medium

### Step 4: StoreMessageRequest
- **What:** Form Request for `store` with validation + participant authorization.
- **Where:** `app/Http/Requests/StoreMessageRequest.php`.
- **How:** `rules()`: `conversation_id` required/exists, `content` required|string|max:2000 (mirror current rules). `authorize()`: returns `true` at HTTP layer; participant enforcement delegated to the service exception path (decision in §2). Keep validation identical to current behavior.
- **Test:** Feature test: missing `content` → 422/redirect with errors; over-max content rejected.
- **Complexity:** Small

### Step 5: Refactor MessageController
- **What:** Reduce controller to thin delegation.
- **Where:** `app/Http/Controllers/MessageController.php`.
- **How:** Add `declare(strict_types=1)`, constructor-inject `MessageService`. `index` → service inbox data + optional selected conversation, return existing view with same compact vars. `show` → `getConversationForUser`, return view. `store` → type-hint `StoreMessageRequest`, call `sendMessage`, redirect as today. `ask` → `startConversation`, redirect as today. Remove all inline queries, `abort(403)`, and `firstOrCreate`.
- **Test:** Existing routes return 200/redirects unchanged; covered by Step 7 feature tests.
- **Complexity:** Medium

### Step 6: Exception rendering
- **What:** Map domain exceptions to HTTP behavior preserving current UX.
- **Where:** `bootstrap/app.php` (`->withExceptions(...)`).
- **How:** `NotConversationParticipantException` → 403. `CannotMessageSelfException` → `redirect()->back()->with('error', 'You cannot message yourself.')` to match current message.
- **Test:** Feature test: non-participant store/show → 403; self-ask → redirect back with `error` flash.
- **Complexity:** Small

### Step 7: Feature tests
- **What:** End-to-end coverage for all four actions.
- **Where:** `tests/Feature/MessageTest.php` (+ factories for `Conversation`/`Message` if missing).
- **How:** Use `RefreshDatabase`. Scenarios: index lists own conversations only; show authorized vs forbidden; store happy path persists + redirects; store validation failure; store by non-participant → 403; ask creates new conversation; ask reuses existing; ask self → redirect with error. Add `ConversationFactory`/`MessageFactory` and seeder updates per architecture rules if data shape changes.
- **Test:** `php artisan test --filter=MessageTest` green.
- **Complexity:** Medium

---

## 4. Risk Assessment

### Risks
- Missing `Conversation`/`Message` factories would block feature tests (none found under `database/factories` referencing them).
- Moving the participant `abort(403)` to an exception could change response shape (HTML vs JSON) if any caller expects the old behavior.
- The `index` user eager-load/`withCount` is a second query that must move to a repository without changing the view contract.
- `Conversation::messages()` is globally ordered `latest()`; the inbox `limit(1)` relies on this — must be preserved.
- Concurrency: replacing `firstOrCreate` must remain a single atomic call to avoid duplicate conversations.

### Mitigations
- Create factories in Step 1/Step 7 before writing tests; update seeders only if data shape changes (per architecture rules).
- Keep `store`/`show` returning the same HTML responses; assert status codes and redirects in tests to lock behavior.
- Route the user query through a repository method and assert identical `loadCount`/relations in tests.
- Add an explicit test asserting inbox returns the latest single message per conversation.
- Keep `findOrCreate` as one repository call wrapping `Conversation::firstOrCreate`.

### Fallbacks
- If exception-based authorization proves risky, keep `StoreMessageRequest::authorize()` returning the participant check (native 403) and drop `NotConversationParticipantException` from the HTTP path, retaining it only for non-HTTP service callers.
- If view-model coupling in `index` is too broad to move cleanly, split into two repository calls (conversations + user) rather than one service method, keeping the controller thin either way.

---

## 5. Execution Checklist

- [ ] Step 1: Create `ConversationRepository` with all conversation/message queries.
- [ ] Step 2: Create `CannotMessageSelfException` and `NotConversationParticipantException`.
- [ ] Step 3: Create `MessageService` with inbox, show, send, and start-conversation logic.
- [ ] Step 4: Create `StoreMessageRequest` with validation rules.
- [ ] Step 5: Refactor `MessageController` to thin delegation with constructor DI.
- [ ] Step 6: Register domain exception rendering in `bootstrap/app.php`.
- [ ] Step 7: Add `MessageTest` feature tests and required factories; run `php artisan test`.
- [ ] code-reviewer approval before merge.
