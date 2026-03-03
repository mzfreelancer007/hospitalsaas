<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Services\AuditLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseApiController
{
    public function __construct(private readonly AuditLogService $auditLogService) {}

    public function login(LoginRequest $request)
    {
        $user = User::query()->where('email', $request->string('email'))->first();
        if (!$user || !Hash::check($request->string('password'), $user->password)) {
            if ($user) {
                $this->auditLogService->log($user->hospital_id, $user->id, 'LOGIN_FAIL', User::class, $user->id, null, $request);
            }
            return $this->error('AUTH_INVALID', 'Invalid credentials.', null, 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;
        $this->auditLogService->log($user->hospital_id, $user->id, 'LOGIN_SUCCESS', User::class, $user->id, null, $request);

        return $this->success([
            'token' => $token,
            'user' => ['id' => $user->id, 'name' => $user->name, 'email' => $user->email],
            'hospital' => ['id' => $user->hospital->id, 'name' => $user->hospital->name, 'code' => $user->hospital->code],
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();
        $this->auditLogService->log($request->user()->hospital_id, $request->user()->id, 'LOGOUT', User::class, $request->user()->id, null, $request);
        return $this->success(['message' => 'Logged out']);
    }
}
