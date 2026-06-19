## Why

The TalentMatch system currently analyzes CVs via a single-prompt AI agent with no conversational memory. HR users cannot ask follow-up questions about candidates, compare candidates, or interact with the system conversationally. The Laravel AI SDK (v0.8.1) provides a full conversational agent framework with function calling, tool support, and conversation persistence — but none of it is wired up.

## What Changes

- Create `ConversationService` as the orchestration layer for chat interactions
- Create three AI tools as Laravel AI `Tool` contracts: `GetCandidateAnalysis`, `GetJobRequirements`, `CompareCandidates`
- Create `RecruitmentAgent` — a conversational agent using `RemembersConversations` trait for multi-turn chat
- Configure `config/ai.php` with conversation store settings pointing to the app's existing `conversations`/`messages` tables
- Create `ChatController` with thin methods for listing conversations and sending messages
- Add Blade chat UI views (index, show) with message history and input form
- Add routes for chat (`/job-offers/{jobOffer}/candidates/{candidate}/chat`) and conversations listing
- Add navigation link to chat in the Breeze layout

## Capabilities

### New Capabilities
- `conversational-agent`: Multi-turn conversational AI assistant with function calling, tool usage, and database-backed conversation persistence

### Modified Capabilities
- *(none)*

## Impact

- **Services**: New `ConversationService` for chat orchestration
- **AI Agent**: New `RecruitmentAgent` using `RemembersConversations` trait
- **Tools**: New `GetCandidateAnalysis`, `GetJobRequirements`, `CompareCandidates` tools in `app/Ai/Tools/`
- **Controller**: New `ChatController`
- **Routes**: New chat routes in `web.php`
- **Config**: Update `config/ai.php` with conversation store table mapping
- **Views**: New chat UI under `resources/views/chat/`
- **Models**: No new models (Conversation, Message exist); no new migrations
