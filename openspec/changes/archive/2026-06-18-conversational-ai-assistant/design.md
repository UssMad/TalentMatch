## Context

The TalentMatch system has a single-prompt `AnalysisAgent` that produces structured CV analysis. It uses the `Promptable` trait with no conversation memory. The app's `Conversation` and `Message` models were created by a prior migration but remain unused. The Laravel AI SDK (v0.8.1) provides `RemembersConversations` trait, `HasConversations` User trait, and `Tool` contract — none of which are wired up.

## Goals / Non-Goals

**Goals:**
- Create `RecruitmentAgent` using `RemembersConversations` trait for multi-turn chat
- Create three AI tools: `GetCandidateAnalysis`, `GetJobRequirements`, `CompareCandidates`
- Publish and run Laravel AI SDK migrations for native conversation tables (`agent_conversations`, `agent_conversation_messages`)
- Add `HasConversations` trait to User model
- Create `ConversationService` to orchestrate chat (start conversation, send message, list conversations)
- Create `ChatController` with thin methods (index, show, store)
- Create Blade chat UI views (list conversations, chat window with message history + input)
- Add chat routes nested under candidates
- Add navigation link to chat in Breeze layout

**Non-Goals:**
- No modifications to the existing `Conversation`/`Message` models or their tables
- No changes to the existing `AnalysisAgent` or `AnalysisPrompt`
- No changes to the `config/ai.php` conversation store settings (native defaults used)
- No streaming, broadcasting, or queueing of agent responses for MVP

## Decisions

- **Use native `RemembersConversations` trait over custom ConversationStore**: The trait auto-manages conversation persistence with zero custom persistence code. We publish the AI SDK native tables (`agent_conversations`, `agent_conversation_messages`) rather than building a custom bridge to the app's unused tables. This follows the AI SDK's documented approach and avoids fragile schema coupling.
- **Tools as standalone classes in `app/Ai/Tools/`**: Each tool implements `Laravel\Ai\Contracts\Tool` with `name()`, `description()`, `schema()`, and `handle()`. Tools query the database directly using Eloquent models (no hallucinated data).
- **Chat routes nested under candidates**: Conversations are scoped to a specific candidate. Route: `/job-offers/{jobOffer}/candidates/{candidate}/chat`. This allows the agent to have context about which candidate the user is discussing.
- **No dedicated chat dashboard page MVP**: The initial chat UI starts from a candidate's show page (a "Chat" button). The conversations index shows all conversations for a candidate.
- **ConversationService as orchestration layer**: Handles creating conversations (via agent), listing conversations for a candidate, and formatting message history for the view.

## Risks / Trade-offs

- **[Risk] Two conversation table sets**: Publishing native AI tables creates a parallel set alongside the app's unused `conversations`/`messages` tables. This could confuse developers. Mitigation: document clearly that the app's tables are legacy/unused for the agent; consider cleaning them up in a follow-up change.
- **[Risk] Tool database queries** (`getCandidateAnalysis`, `getJobRequirements`, `compareCandidates`) hit the database directly. If the AI calls tools in rapid succession, it could cause N+1 patterns. Mitigation: tools are simple single-model queries; the AI typically calls them 1-3 times per turn, so performance impact is acceptable for MVP.
- **[Risk] No provider configuration for agent** — the agent uses the default OpenAI provider. Mitigation: users can override with `#[Provider(Lab::Anthropic)]` attribute later.
