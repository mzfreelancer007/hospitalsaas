<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Requests\Users\UpdateUserStatusRequest;
use App\Models\User;
use App\Services\AuditLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseApiController
{
    public function __construct(private readonly AuditLogService $auditLogService) {}

    public function index(Request $request)
    {
        $q = User::query()->where('hospital_id', $request->user()->hospital_id)
            ->when($request->search, fn ($b) => $b->where(fn ($x) => $x->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%")
                ->orWhere('phone', 'like', "%{$request->search}%")));
        return $this->success($q->paginate(15));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create(array_merge($request->safe()->except('role_ids'), [
            'hospital_id' => $request->user()->hospital_id,
            'password' => Hash::make($request->password),
        ]));
        $user->roles()->sync($request->role_ids);
        $this->auditLogService->log($request->user()->hospital_id, $request->user()->id, 'USER_CREATED', User::class, $user->id, null, $request);
        return $this->success($user, 201);
    }

    public function show(int $id) { return $this->success(User::query()->findOrFail($id)); }

    public function update(UpdateUserRequest $request, int $id)
    {
        $user = User::query()->findOrFail($id);
        $user->update($request->safe()->except('role_ids'));
        if ($request->has('role_ids')) $user->roles()->sync($request->role_ids);
        $this->auditLogService->log($request->user()->hospital_id, $request->user()->id, 'USER_UPDATED', User::class, $user->id, null, $request);
        return $this->success($user);
    }

    public function status(UpdateUserStatusRequest $request, int $id)
    {
        $user = User::query()->findOrFail($id);
        $user->update(['is_active' => $request->boolean('is_active')]);
        $this->auditLogService->log($request->user()->hospital_id, $request->user()->id, 'USER_STATUS_CHANGED', User::class, $user->id, ['is_active'=>$user->is_active], $request);
        return $this->success($user);
    }
}
