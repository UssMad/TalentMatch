# TalentMatch - AI Coding Agent Rules

## Project Context
This project is an AI-powered recruitment system built with Laravel.
It includes structured AI outputs, job queues, and a conversational agent with tools and memory.

---

## Core Rules (MANDATORY)

### 1. Architecture Rules
- Use Laravel best practices
- Controllers must remain thin
- Business logic must be inside Services
- Database access only via Eloquent models
- No raw queries unless necessary

---

### 2. AI System Rules
- AI MUST return structured JSON only (no free text storage)
- AI responses must be validated before saving
- AI must NEVER hallucinate data
- AI must use tools for real database access

---

### 3. Queue System Rules
- All AI analysis must run in Laravel Jobs (async)
- Never execute AI calls inside controllers
- Use Redis queue driver

---

### 4. Tools Usage (Function Calling)
The agent MUST use tools instead of guessing:

- getCandidateAnalysis(candidateId)
- getJobRequirements(jobOfferId)
- compareCandidates(id1, id2)

If data is not available via tools → do NOT hallucinate.

---

### 5. Data Integrity Rules
- Matching score must be integer (0–100)
- Recommendation must follow enum:
  - convoquer
  - attente
  - rejeter

---

### 6. Code Quality Rules
- Follow PSR-12 standards
- Avoid duplicated logic
- Always use Form Requests for validation
- Always use Eloquent relationships
- Prevent N+1 queries

---

### 7. OpenSpec Compliance
- Every feature must follow OpenSpec definitions
- Do not implement features without a spec file
- Do not modify architecture outside spec scope

---

## Goal
The goal is to ensure predictable, production-grade, AI-assisted Laravel development with strict architecture and no hallucinated logic.