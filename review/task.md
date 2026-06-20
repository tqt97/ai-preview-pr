# Task

## Title

Implement optimistic locking for Counter.

## Goal

Prevent lost update.

## Acceptance Criteria

- Counter must never become negative.
- Concurrent update must throw exception.
- Retry is allowed.
- Keep existing API unchanged.
