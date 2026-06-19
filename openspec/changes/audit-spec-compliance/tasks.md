## 1. Data Model Specs Audit

- [ ] 1.1 Audit candidate-schema spec against Candidate.php, migration, and factory
- [ ] 1.2 Audit analysis-schema spec against Analysis.php, AnalysisValidator.php, Recommendation.php, and migration
- [ ] 1.3 Audit message-model spec against Message.php and migration
- [ ] 1.4 Audit conversation-model spec against Conversation.php and migration

## 2. CRUD Feature Specs Audit

- [ ] 2.1 Audit candidate-crud spec against CandidateController, CandidatePolicy, Form Requests, views, and tests
- [ ] 2.2 Audit job-offer-crud spec against JobOfferController, JobOfferPolicy, Form Requests, views, and tests

## 3. UI Specs Audit

- [ ] 3.1 Audit job-offer-ui spec against Blade views (index, create, edit, show, dashboard)

## 4. AI System Specs Audit

- [ ] 4.1 Audit conversational-agent spec against RecruitmentAgent, tools, ConversationService, ChatController, and views
- [ ] 4.2 Audit ai-analysis-pipeline spec against AnalysisController, RunAnalysisJob, AIAnalysisService, AnalysisAgent, and views
- [ ] 4.3 Audit candidate-cv-submit spec against Candidate model events (booted method) and tests

## 5. AGENTS.md Rules Compliance Audit

- [ ] 5.1 Verify Architecture Rules (thin controllers, services, Eloquent, no raw queries)
- [ ] 5.2 Verify AI System Rules (structured JSON, validation, no hallucination, tools)
- [ ] 5.3 Verify Queue System Rules (jobs, no AI in controllers, Redis driver)
- [ ] 5.4 Verify Tools Usage (getCandidateAnalysis, getJobRequirements, compareCandidates)
- [ ] 5.5 Verify Data Integrity Rules (matching_score 0-100, Recommendation enum)
- [ ] 5.6 Verify Code Quality Rules (PSR-12, Form Requests, Eloquent relationships, N+1 prevention)

## 6. Test Coverage Audit

- [ ] 6.1 Verify test coverage matches spec scenarios for all specs
- [ ] 6.2 Run test suite and report results

## 7. Final Report

- [ ] 7.1 Compile all findings into a structured audit report
- [ ] 7.2 Categorize findings by priority (HIGH / MEDIUM / LOW)
