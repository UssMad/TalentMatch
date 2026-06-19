## 1. Database & Config

- [x] 1.1 Publish and run Laravel AI SDK migrations for conversation tables (`agent_conversations`, `agent_conversation_messages`)
- [x] 1.2 Add `HasConversations` trait to User model

## 2. AI Tools

- [x] 2.1 Create `GetCandidateAnalysis` tool class
- [x] 2.2 Create `GetJobRequirements` tool class
- [x] 2.3 Create `CompareCandidates` tool class

## 3. Agent & Service

- [x] 3.1 Create `RecruitmentAgent` with `RemembersConversations` trait and tool registration
- [x] 3.2 Create `ConversationService` for chat orchestration

## 4. Controller & Routes

- [x] 4.1 Create `ChatController` with index, show, and store methods
- [x] 4.2 Add chat routes nested under candidates in `web.php`

## 5. Views

- [x] 5.1 Create `chat/index.blade.php` (conversations list for a candidate)
- [x] 5.2 Create `chat/show.blade.php` (chat window with message history and input form)
- [x] 5.3 Add "Chat" button to candidate show page and navigation link

## 6. Final Quality

- [x] 6.1 Run `vendor/bin/pint` to format all modified PHP files
- [x] 6.2 Run `php artisan test --compact` to verify all tests pass
