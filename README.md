# Multi-tenant HMS (Laravel-style scaffold)

## Run

```bash
php artisan migrate
php artisan db:seed
php artisan serve
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
