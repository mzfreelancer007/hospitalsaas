<?php

namespace App\Services;

use App\Models\Hospital;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HospitalOnboardingService
{
    public function __construct(private readonly AuditLogService $auditLogService) {}

    public function onboard(array $payload, $request): array
    {
        return DB::transaction(function () use ($payload, $request): array {
            $hospital = Hospital::create(['name' => $payload['hospital_name'], 'code' => $payload['hospital_code']]);

            $owner = User::create([
                'hospital_id' => $hospital->id,
                'name' => $payload['owner']['name'],
                'email' => $payload['owner']['email'],
                'phone' => $payload['owner']['phone'] ?? null,
                'password' => Hash::make($payload['owner']['password']),
            ]);

            $roles = collect(['OWNER','ADMIN','DOCTOR','NURSE','RECEPTION','ACCOUNTANT'])->mapWithKeys(
                fn (string $role) => [$role => Role::create(['hospital_id' => $hospital->id, 'name' => $role, 'key' => strtolower($role)])]
            );

            $permissionMap = config('hms.role_permissions');
            foreach ($permissionMap as $roleKey => $permissionKeys) {
                $role = $roles[strtoupper($roleKey)] ?? null;
                if (!$role) continue;
                $permissionIds = Permission::query()->whereIn('key', $permissionKeys)->pluck('id');
                $role->permissions()->syncWithoutDetaching($permissionIds);
            }

            $owner->roles()->syncWithoutDetaching([$roles['OWNER']->id]);
            $token = $owner->createToken('owner-token')->plainTextToken;

            $this->auditLogService->log($hospital->id, $owner->id, 'HOSPITAL_CREATED', Hospital::class, $hospital->id, null, $request);

            return compact('hospital', 'owner', 'token');
        });
    }
}
