## Context

TalentMatch has significant code and spec assets built over multiple archived changes. No systematic compliance verification has been performed. The audit must cover 10 spec files, 7 AGENTS.md rule categories, ~20 PHP feature files, 12 test files, and 47+ Blade views.

## Goals / Non-Goals

**Goals:**
- Verify every spec requirement has a corresponding implementation
- Identify violations of AGENTS.md architecture, AI, queue, data integrity, and code quality rules
- Check test coverage against spec scenarios
- Document all gaps, inconsistencies, and violations with file references

**Non-Goals:**
- No code fixes or remediation
- No new test writing
- No architectural changes

## Decisions

- **Manual audit over automated**: Spec requirements are narrative/scenario-based. Automated tools cannot reliably verify natural-language "SHALL" statements. Manual code inspection is required.
- **Per-spec mapping**: Each spec will be read against the actual codebase (routes, controllers, services, models, jobs, tests, views) with a COMPLIANT / PARTIAL / VIOLATED / MISSING verdict per scenario.
- **Rule checklist**: AGENTS.md rules will be checked as a binary pass/fail per rule.
- **Evidence capture**: Every finding will include the exact file path and line number.

## Risks / Trade-offs

- [Audit completeness] → The audit may miss edge cases not covered by specs. Mitigation: Check beyond spec boundaries for common Laravel violations (N+1, raw queries, fat controllers).
- [Audit accuracy] → Manual inspection can miss issues. Mitigation: Run `pint` to verify PSR-12 compliance, review queue config, and verify test output.
