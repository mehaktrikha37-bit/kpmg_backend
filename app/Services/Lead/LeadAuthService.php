<?php

namespace App\Services\Lead;

use App\Repositories\Lead\Interfaces\LeadUserRepositoryInterface;
use App\Models\LeadUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LeadAuthService
{
    protected LeadUserRepositoryInterface $userRepository;

    public function __construct(LeadUserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Authenticate a lead user via mobile + password and return a Sanctum token.
     */
    public function login(string $mobile, string $password): array
    {
        $user = LeadUser::where('mobile', $mobile)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'mobile' => ['Invalid mobile number or password.'],
            ]);
        }

        if ($user->status !== 'active') {
            throw ValidationException::withMessages([
                'mobile' => ['Your account has been deactivated. Please contact the Super Admin.'],
            ]);
        }

        // Revoke any previous tokens for single-session-per-device (optional)
        // $user->tokens()->delete();

        $token = $user->createToken('lead_auth_token')->plainTextToken;

        return [
            'token' => $token,
            'user'  => $user,
        ];
    }

    /**
     * Revoke the current access token.
     */
    public function logout(LeadUser $user): void
    {
        $user->currentAccessToken()->delete();
    }

    /**
     * Change a user's password.
     */
    public function changePassword(
        LeadUser $user,
        string $newPassword,
        ?string $currentPassword = null,
        bool $isForceReset = false
    ): void {
        if (!$isForceReset) {
            if (!$currentPassword || !Hash::check($currentPassword, $user->password)) {
                throw ValidationException::withMessages([
                    'current_password' => ['The current password you entered is incorrect.'],
                ]);
            }
        }

        $this->userRepository->update($user->id, [
            'password'         => $newPassword, // hashed automatically by model cast
            'is_temp_password' => false,
            'temp_password'    => null,
        ]);
    }
}
