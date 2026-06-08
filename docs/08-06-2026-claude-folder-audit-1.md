# Implementation Plan: .claude Folder Audit & Fixes

**Date:** 08-06-2026
**Plan ID:** 1
**Status:** Draft
**Complexity:** Small

---

## 1. Requirements Analysis

### Functional Requirements
- [ ] Fill `command-review.md` — currently empty (1 line), breaks the main review execution flow
- [ ] Fill `laravel.md` — currently empty (1 line), should contain Laravel-specific coding rules
- [ ] Fix wrong project reference in `code-reviewer.md` — refers to "checkout-process project rules" instead of Artify
- [ ] Add missing coordinator agents — `command-explain.md` and `command-refactor.md` delegate to agents that do not exist
- [ ] Fix section gap in `conventions.md` — goes from section 2 directly to section 4 (section 3 missing)
- [ ] Expand `architecture.md` — too sparse; missing Livewire, Repositories, and Exceptions layer patterns

### Non-Functional Requirements
- [ ] All agent and command files must be internally consistent and self-contained
- [ ] All cross-references between files must point to things that actually exist
- [ ] Files must follow the same formatting and heading style as the rest of the folder

---

## 2. Architecture Review

### Existing Codebase Patterns

- Commands in `commands/` delegate to named agents via `agent:` frontmatter
- Agents in `agents/` have `name:`, `description:`, `tools:`, `model:`, `color:` frontmatter
- Rules in `rules/` are plain Markdown with no frontmatter
- `CLAUDE.md` is the top-level context file loaded in every conversation

### Affected Areas

| File | Issue | Severity |
|------|-------|----------|
| `.claude/commands/command-review.md` | Empty — 1 line only | Critical |
| `.claude/rules/laravel.md` | Empty — 1 line only | High |
| `.claude/agents/code-reviewer.md` | Wrong project name on line 9 | Medium |
| `.claude/commands/command-explain.md` | Delegates to non-existent `acc:explain-coordinator` | Medium |
| `.claude/commands/command-refactor.md` | Delegates to non-existent `acc:refactor-coordinator` | Medium |
| `.claude/rules/conventions.md` | Section 3 missing (jumps 2 → 4) | Low |
| `.claude/rules/architecture.md` | Missing Livewire, Repository, Exceptions patterns | Low |

### Reusable Components
- `code-reviewer.md` agent already defines the full review output format — `command-review.md` just needs to delegate to it
- `code-executer.md` and `tech-lead-architect.md` can serve as templates for any missing coordinator agents
- Laravel rules can be derived from the architecture already described in `CLAUDE.md`

### Architecture Decision
- Coordinator agents referenced in `command-explain.md` and `command-refactor.md` should either be created as real agent files in `agents/`, or the commands should be simplified to delegate directly to existing agents (`tech-lead-architect`, `code-executer`) rather than relying on non-existent ones.
- Simplest fix: remove coordinator delegation from explain/refactor commands and route them directly to the appropriate existing agent.

---

## 3. Step Breakdown

### Step 1: Fill `command-review.md`
- **What:** Write the review command content that invokes the `code-reviewer` agent on recently changed files
- **Where:** `.claude/commands/command-review.md`
- **How:** Mirror the structure of `command-implement.md`; add frontmatter with `agent: code-reviewer`, describe input (plan file or diff), review scope, and expected output format
- **Test:** Invoke `/command-review` and verify it routes to the code-reviewer agent and produces a structured report
- **Complexity:** Small

### Step 2: Fill `laravel.md`
- **What:** Add Laravel-specific coding rules covering Eloquent, Blade, Livewire, routing, service providers, and artisan
- **Where:** `.claude/rules/laravel.md`
- **How:** Derive rules from what's already described in `CLAUDE.md` and `architecture.md`; add idiomatic Laravel conventions not yet covered (e.g. route model binding, form requests, observers, policies)
- **Test:** Confirm the file is non-empty and covers at least: Eloquent patterns, Blade, Livewire, Authorization, and Form Requests
- **Complexity:** Small

### Step 3: Fix wrong project name in `code-reviewer.md`
- **What:** Replace "checkout-process project rules" with "Artify project rules" on line 9
- **Where:** `.claude/agents/code-reviewer.md:9`
- **How:** Simple string replacement
- **Test:** Read the file and confirm no reference to "checkout-process"
- **Complexity:** Small

### Step 4: Resolve missing coordinator agents
- **What:** Either create stub agents for `acc:explain-coordinator` and `acc:refactor-coordinator`, or simplify the commands to not rely on non-existent agents
- **Where:** `.claude/commands/command-explain.md`, `.claude/commands/command-refactor.md`, and optionally `.claude/agents/`
- **How:** Simplest path — update the delegation in each command to route directly to `tech-lead-architect` (explain) and `code-executer` (refactor) instead of non-existent coordinators. Alternatively, create minimal coordinator agent files if full multi-step delegation is desired.
- **Test:** Verify each command's `agent:` frontmatter or Task delegation points to an agent file that actually exists in `agents/`
- **Complexity:** Small

### Step 5: Fix section gap in `conventions.md`
- **What:** Add missing section 3 or renumber existing sections so there is no gap
- **Where:** `.claude/rules/conventions.md`
- **How:** Section 3 likely should be "Naming Conventions" — add a short section, or if intentionally removed, renumber section 4 → 3 and so on
- **Test:** Read the file and confirm sequential section numbering
- **Complexity:** Small

### Step 6: Expand `architecture.md`
- **What:** Add sections for Livewire, Repositories, Exceptions, and Form Requests patterns not currently documented
- **Where:** `.claude/rules/architecture.md`
- **How:** Extract patterns already described in `CLAUDE.md` and codify them as rules (e.g. "Repositories are the only layer that may query the database", "Livewire components should not contain business logic")
- **Test:** Confirm the file documents all layers listed in `CLAUDE.md` structure
- **Complexity:** Small

---

## 4. Risk Assessment

### Risks
- **command-review.md content** — If the review command is written incorrectly, the `/command-review` flow will route to the wrong agent or produce incomplete output
- **coordinator agent decision** — Creating full coordinator agents is larger scope than a simple redirect; choosing the wrong approach adds complexity without value
- **architecture.md expansion** — Adding too many rules could conflict with what's already in `CLAUDE.md` or `conventions.md`, creating duplication

### Mitigations
- Write `command-review.md` by following the exact same structure as `command-implement.md` — safe and consistent
- Choose the simplest fix for coordinator agents: redirect existing commands directly to existing agents, no new files needed
- Keep `architecture.md` additions to patterns not already covered elsewhere; cross-reference rather than duplicate

### Fallbacks
- If the coordinator agent approach is wanted long-term, create minimal stubs now with a TODO for full implementation
- If `conventions.md` section 3 was intentionally removed, just add a note explaining the gap rather than inventing content

---

## 5. Execution Checklist

- [ ] Step 1: Fill `command-review.md` with review command content
- [ ] Step 2: Fill `laravel.md` with Laravel-specific coding rules
- [ ] Step 3: Fix "checkout-process" reference in `code-reviewer.md`
- [ ] Step 4: Resolve missing coordinator agents in explain/refactor commands
- [ ] Step 5: Fix section numbering gap in `conventions.md`
- [ ] Step 6: Expand `architecture.md` with missing layer patterns
