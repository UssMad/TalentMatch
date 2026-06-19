## MODIFIED Requirements

### Requirement: Chat UI

The system SHALL provide a web chat interface for interacting with the agent. The chat interface SHALL use the brand design system with a modern messaging layout.

#### Scenario: Chat page renders message history
- **WHEN** a user visits a conversation chat page
- **THEN** the page SHALL display previous messages with user and assistant roles in a styled chat bubble layout
- **THEN** user messages SHALL appear right-aligned with brand-colored bubbles
- **THEN** assistant messages SHALL appear left-aligned with neutral-colored bubbles
- **THEN** the page SHALL display a text input for sending new messages

#### Scenario: Send a message and receive a response
- **WHEN** a user submits a message via the chat form
- **THEN** the message SHALL be sent to the agent
- **THEN** the response SHALL be displayed in the chat window
- **THEN** the user SHALL be redirected back to the conversation page

#### Scenario: Chat bubbles display timestamps
- **WHEN** a chat message is displayed
- **THEN** the message SHALL include a timestamp showing when it was created

#### Scenario: Unauthenticated user is redirected to login
- **WHEN** a guest visits any chat page
- **THEN** the system SHALL redirect to the login page
