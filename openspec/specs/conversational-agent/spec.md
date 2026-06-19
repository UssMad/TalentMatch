# Conversational Agent

## Purpose

Provide a conversational AI assistant (`RecruitmentAgent`) that allows recruiters to interact with candidate analysis data through a chat interface. The agent uses conversation memory to maintain context across turns and exposes database-backed tools for accurate responses.

## Requirements

### Requirement: RecruitmentAgent with conversation memory

The system SHALL provide a conversational AI agent (`RecruitmentAgent`) that remembers conversation history across turns. The agent SHALL use the `RemembersConversations` trait and SHALL persist messages to the `agent_conversations` and `agent_conversation_messages` tables.

#### Scenario: Start a new conversation
- **WHEN** a user starts a chat about a candidate
- **THEN** a new conversation SHALL be created and persisted
- **THEN** the agent SHALL respond to the user's message

#### Scenario: Continue an existing conversation
- **WHEN** a user sends a follow-up message in an existing conversation
- **THEN** the agent SHALL load previous messages from the conversation history
- **THEN** the agent SHALL respond with context from prior messages

#### Scenario: List user conversations for a candidate
- **WHEN** a user views conversations for a candidate
- **THEN** the system SHALL display all conversations for that user and candidate, ordered by most recent

### Requirement: AI tools for database access

The agent SHALL expose three tools that query the database directly. The agent SHALL use these tools instead of inventing answers.

#### Scenario: getCandidateAnalysis tool
- **WHEN** the agent calls `getCandidateAnalysis(candidateId)`
- **THEN** the tool SHALL return the analysis data (matching score, recommendation, structured data) for the given candidate
- **THEN** the tool SHALL return null if no analysis exists

#### Scenario: getJobRequirements tool
- **WHEN** the agent calls `getJobRequirements(jobOfferId)`
- **THEN** the tool SHALL return the job offer's title, description, required skills, and minimum experience
- **THEN** the tool SHALL return null if the job offer does not exist

#### Scenario: compareCandidates tool
- **WHEN** the agent calls `compareCandidates(candidateId1, candidateId2)`
- **THEN** the tool SHALL return a comparison of both candidates' analyses, skills, scores, and recommendations
- **THEN** the tool SHALL handle cases where one or both candidates lack analysis data

### Requirement: Chat UI

The system SHALL provide a web chat interface for interacting with the agent.

#### Scenario: Chat page renders message history
- **WHEN** a user visits a conversation chat page
- **THEN** the page SHALL display previous messages with user and assistant roles
- **THEN** the page SHALL display a text input for sending new messages

#### Scenario: Send a message and receive a response
- **WHEN** a user submits a message via the chat form
- **THEN** the message SHALL be sent to the agent
- **THEN** the response SHALL be displayed in the chat window
- **THEN** the user SHALL be redirected back to the conversation page

#### Scenario: Unauthenticated user is redirected to login
- **WHEN** a guest visits any chat page
- **THEN** the system SHALL redirect to the login page
