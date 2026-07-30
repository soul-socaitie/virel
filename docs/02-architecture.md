# Virel Architecture

Version: 1.0
Status: Draft
Author: Nurbek Andaqulov

---

# Overview

Virel is designed using a modular, scalable architecture.

Every major responsibility is isolated into its own component.

This allows the platform to evolve without rewriting existing systems.

---

# High Level Architecture

```
                   Telegram
                        │
                        ▼
              Telegram Gateway
                        │
                        ▼
         Conversation Orchestrator
                        │
 ┌──────────────┬──────────────┬──────────────┐
 │              │              │              │
 ▼              ▼              ▼              ▼
Memory      Personality     Emotion      Context
Engine        Engine         Engine       Engine
 │              │              │              │
 └──────────────┴──────────────┴──────────────┘
                        │
                        ▼
              Prompt Composer
                        │
                        ▼
               AI Provider Layer
                        │
                        ▼
             Response Processor
                        │
                        ▼
             Telegram Formatter
                        │
                        ▼
                  Telegram User
```

---

# Core Principles

The architecture must remain:

- Modular
- Scalable
- Testable
- Maintainable
- Platform Independent

---

# Main Components

## Telegram Gateway

Responsible for:

- Receiving Telegram updates
- Validating requests
- Sending responses

No business logic should exist here.

---

## Conversation Orchestrator

The heart of the system.

Responsibilities:

- Receive user message
- Load user profile
- Load memories
- Detect conversation state
- Execute AI pipeline
- Save results

Everything passes through this module.

---

## Memory Engine

Responsibilities

- Store memories
- Retrieve memories
- Rank memories
- Forget unnecessary memories
- Update existing memories

Memory should improve conversations.

---

## Personality Engine

Responsibilities

- Maintain Virel personality
- Adapt to selected character
- Keep consistent tone
- Control speaking style

---

## Emotion Engine

Responsibilities

- Detect user emotion
- Detect conversation mood
- Adjust response style

Emotion changes the way Virel responds,
not what Virel believes.

---

## Context Engine

Responsibilities

- Understand conversation history
- Detect topic changes
- Maintain context

---

## Prompt Composer

Responsibilities

Collect information from:

- Personality
- Memory
- Emotion
- Context

Create one optimized prompt for the AI model.

---

## AI Provider Layer

This layer communicates with AI providers.

Initially:

- OpenAI

Future:

- Claude
- Gemini
- Local Models

Switching providers should require minimal changes.

---

## Response Processor

Responsibilities

- Validate output
- Apply formatting
- Apply safety rules
- Improve readability

---

# Design Rules

Controllers must remain thin.

Business logic belongs inside Services.

AI logic belongs inside AI modules.

Database logic belongs inside repositories or dedicated services.

---

# Future Clients

The core architecture should support:

- Telegram
- Web
- Mobile
- Desktop
- API

without changing the AI Core.

---

# Folder Philosophy

Every folder should have a single responsibility.

Large files should be divided.

Avoid "God Classes".

---

# Long-Term Goal

The AI Core should be reusable by any future application.

Telegram is only the first client.

---

End of Document
