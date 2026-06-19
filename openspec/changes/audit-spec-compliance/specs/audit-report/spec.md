## ADDED Requirements

### Requirement: Audit covers all spec requirements against implementation

The audit SHALL verify every scenario in every OpenSpec file has a corresponding implementation in the codebase. Each scenario SHALL receive a verdict of COMPLIANT, PARTIAL, VIOLATED, or MISSING.

#### Scenario: Candidate schema scenarios are audited
- **WHEN** the candidate-schema spec is checked
- **THEN** every scenario (fillable attributes, relationships, cascade delete) SHALL be verified against Candidate.php and the candidates migration

#### Scenario: Analysis schema scenarios are audited
- **WHEN** the analysis-schema spec is checked
- **THEN** every scenario (structured data fields, matching score range, recommendation enum, validation) SHALL be verified against Analysis.php, AnalysisValidator.php, Recommendation.php, and the analyses migration

#### Scenario: Message model scenarios are audited
- **WHEN** the message-model spec is checked
- **THEN** every scenario (fillable, relationships, ordering, cascade delete) SHALL be verified against Message.php and the messages migration

#### Scenario: Conversation model scenarios are audited
- **WHEN** the conversation-model spec is checked
- **THEN** every scenario (fillable, relationships, optional candidate association) SHALL be verified against Conversation.php and the conversations migration

#### Scenario: Candidate CRUD scenarios are audited
- **WHEN** the candidate-crud spec is checked
- **THEN** every scenario (list, view, create, edit, delete, authorization, validation) SHALL be verified against CandidateController.php, CandidatePolicy.php, Form Requests, and views

#### Scenario: Job offer CRUD scenarios are audited
- **WHEN** the job-offer-crud spec is checked
- **THEN** every scenario (list, view, create, edit, delete, authorization, validation) SHALL be verified against JobOfferController.php, JobOfferPolicy.php, Form Requests, and views

#### Scenario: Job offer UI scenarios are audited
- **WHEN** the job-offer-ui spec is checked
- **THEN** every scenario (index page, create form, edit form, show page) SHALL be verified against Blade views and routes

#### Scenario: Conversational agent scenarios are audited
- **WHEN** the conversational-agent spec is checked
- **THEN** every scenario (RecruitmentAgent, conversation memory, tools, chat UI) SHALL be verified against RecruitmentAgent.php, tools, ConversationService.php, ChatController.php, and views

#### Scenario: AI analysis pipeline scenarios are audited
- **WHEN** the ai-analysis-pipeline spec is checked
- **THEN** every scenario (trigger analysis, async job, structured output, validation failure, view results) SHALL be verified against AnalysisController.php, RunAnalysisJob.php, AIAnalysisService.php, AnalysisAgent.php, and views

#### Scenario: Candidate CV submit scenarios are audited
- **WHEN** the candidate-cv-submit spec is checked
- **THEN** every scenario (auto-dispatch on create, auto-dispatch on update, skip without job_offer, failure handling) SHALL be verified against Candidate.php model events and RunAnalysisJob.php

### Requirement: Audit covers AGENTS.md rule compliance

The audit SHALL evaluate the application against every rule category in AGENTS.md.

#### Scenario: Architecture rules checked
- **WHEN** controllers, services, and queries are inspected
- **THEN** the audit SHALL verify controllers are thin, business logic is in Services, database access uses Eloquent, and no raw queries exist

#### Scenario: AI system rules checked
- **WHEN** AI outputs and tools are inspected
- **THEN** the audit SHALL verify AI returns structured JSON, responses are validated before saving, and AI uses tools for database access

#### Scenario: Queue system rules checked
- **WHEN** queue configuration and AI calls are inspected
- **THEN** the audit SHALL verify all AI analysis runs in Jobs, no AI calls exist in controllers, and the queue driver is Redis

#### Scenario: Tools usage rules checked
- **WHEN** the RecruitmentAgent tools are inspected
- **THEN** the audit SHALL verify the three required tools exist and are used by the agent

#### Scenario: Data integrity rules checked
- **WHEN** matching scores and recommendations are inspected
- **THEN** the audit SHALL verify matching_score is integer 0-100 and recommendation uses the correct enum

#### Scenario: Code quality rules checked
- **WHEN** code style and patterns are inspected
- **THEN** the audit SHALL verify PSR-12, Form Request usage, Eloquent relationships, and N+1 prevention

### Requirement: Audit report is actionable

The audit SHALL produce a structured report with findings organized by spec file and rule category, with file paths and line numbers for each issue.

#### Scenario: Findings include evidence
- **WHEN** a violation or gap is identified
- **THEN** the finding SHALL include the file path, line number, and a description of the issue

#### Scenario: Report prioritized
- **WHEN** all findings are collected
- **THEN** the report SHALL categorize issues by priority (HIGH / MEDIUM / LOW)
