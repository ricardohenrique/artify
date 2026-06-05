# Architecture Patterns

## Business Logic

- **Service Layer**: implemented via Service classes

## Frontend

- **blade** build with blade

## Database

- Every DB structure change → new migration
- Every DB data change → update seeder + factory
- Prefer Eloquent models over raw queries (`DB::` facade)
- Prefer Eloquent relationships over manual joins
- Prefer Eloquent eager loading over lazy loading (N+1 prevention)
