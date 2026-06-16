## ADDED Requirements

### Requirement: Message stores individual chat turns with tool call tracking

The `messages` table SHALL persist each turn in a conversation. Every message MUST belong to exactly one conversation. Messages SHALL track the sender role, content, and any AI tool calls made during that turn.

#### Scenario: Create a message in a conversation
- **WHEN** a message is created with `conversation_id`, `role` (user/assistant/system), `content`, and optional `tool_calls` JSON
- **THEN** the message record SHALL be persisted in the `messages` table with a foreign key referencing the `conversations` table

#### Scenario: Message belongs to conversation
- **WHEN** accessing `$message->conversation`
- **THEN** the relationship SHALL return the parent `Conversation` model

#### Scenario: Messages ordered by creation time
- **WHEN** retrieving messages for a conversation
- **THEN** they SHALL be ordered by `created_at` ascending to preserve conversation order

#### Scenario: Delete conversation cascades to messages
- **WHEN** a conversation record is deleted
- **THEN** all associated message records SHALL be deleted automatically

#### Scenario: Role is a plain string field
- **WHEN** setting the `role` attribute
- **THEN** the value SHALL be one of: `user`, `assistant`, `system`
