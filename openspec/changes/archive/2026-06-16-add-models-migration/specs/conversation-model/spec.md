## ADDED Requirements

### Requirement: Conversation stores chat sessions with context

The `conversations` table SHALL persist conversational AI sessions. Each conversation MUST belong to one user and optionally to one candidate. Conversation context SHALL be stored as JSON for flexible metadata.

#### Scenario: Create a conversation for a user
- **WHEN** a conversation is created with `user_id`, `title`, and optional `candidate_id` and `context` JSON
- **THEN** the conversation record SHALL be persisted in the `conversations` table with a foreign key referencing the `users` table and optionally referencing `candidates`

#### Scenario: Conversation belongs to user
- **WHEN** accessing `$conversation->user`
- **THEN** the relationship SHALL return the parent `User` model

#### Scenario: Conversation optionally belongs to candidate
- **WHEN** accessing `$conversation->candidate`
- **THEN** the relationship SHALL return the associated `Candidate` model or null

#### Scenario: Conversation has many messages
- **WHEN** accessing `$conversation->messages`
- **THEN** the relationship SHALL return a collection of associated `Message` models ordered by `created_at` ascending
