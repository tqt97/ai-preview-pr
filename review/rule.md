# Coding Rules

Architecture

Controller

- no business logic

Service

- transaction

Repository

- database only

Performance

- no N+1

SQL

- EXISTS over COUNT
- avoid select *

Security

- validate input
- parameter binding

PHP

- SOLID
- strict_types
- typed property
- early return

Legacy

- no duplicated logic
- backward compatible

Regression

- check reused services
- check shared model
