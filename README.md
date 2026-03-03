# Multi-tenant HMS (Laravel-style scaffold)

**Current version:** `0.1.0`

This is the first release of the Hospital Management System API scaffold with multi-tenant data isolation by hospital.

## Run

```bash
php artisan migrate --fresh
php artisan db:seed
php artisan serve --host 127.0.0.1 --port 8000
```

## Testing

This scaffold includes a lightweight local test runner so tests can run without external package downloads in restricted environments.

```bash
php artisan test
./vendor/bin/phpunit --testdox
```

## Testing

This scaffold includes a lightweight local test runner so tests can run without external package downloads in restricted environments.

```bash
php artisan test
./vendor/bin/phpunit --testdox
```

## Tenant enforcement
- `tenant.context` middleware resolves the authenticated user's `hospital_id` into `TenantContext`.
- `BelongsToHospital` global scope enforces `where hospital_id = current tenant` automatically.
- `BelongsToHospital` also auto-fills `hospital_id` on create.

## Key API endpoints
- `POST /api/v1/onboarding/hospitals`
- `POST /api/v1/auth/login`
- `POST /api/v1/auth/logout`
- Staff users: `/api/v1/users`
- Patients: `/api/v1/patients`
- Departments: `/api/v1/departments`
- Doctors: `/api/v1/doctors`
- Appointments: `/api/v1/appointments`


## Scaffold artisan commands
- `php artisan migrate [--fresh]` creates the local SQLite schema at `database/database.sqlite`.
- `php artisan db:seed` upserts default permission records.
- `php artisan test` runs the local test suite.
- `php artisan serve [--host <host>] [--port <port>]` starts the built-in API server.
