<?php

namespace App\Http\Controllers\Api\Lead;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lead\LeadLoginRequest;
use App\Http\Requests\Lead\LeadChangePasswordRequest;
use App\Http\Resources\Lead\LeadUserResource;
use App\Services\Lead\LeadAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LeadAuthController extends Controller
{
    protected LeadAuthService $authService;

    public function __construct(LeadAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LeadLoginRequest $request): JsonResponse
    {
        $result = $this->authService->login(
            $request->input('mobile'),
            $request->input('password')
        );

        return response()->json([
            'token' => $result['token'],
            'user'  => new LeadUserResource($result['user']),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        /** @var \App\Models\LeadUser $user */
        $user = $request->user();
        $this->authService->logout($user);

        return response()->json([
            'message' => 'Logged out successfully.',
        ]);
    }

    public function changePassword(LeadChangePasswordRequest $request): JsonResponse
    {
        /** @var \App\Models\LeadUser $user */
        $user = $request->user();

        $this->authService->changePassword(
            $user,
            $request->input('new_password'),
            $request->input('current_password'),
            (bool) $request->input('is_force_reset', false)
        );

        return response()->json([
            'message' => 'Password updated successfully.',
        ]);
    }
}
