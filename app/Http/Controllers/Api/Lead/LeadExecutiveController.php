<?php

namespace App\Http\Controllers\Api\Lead;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lead\StoreLeadExecutiveRequest;
use App\Http\Requests\Lead\UpdateLeadExecutiveRequest;
use App\Http\Resources\Lead\LeadUserResource;
use App\Services\Lead\LeadExecutiveService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LeadExecutiveController extends Controller
{
    protected LeadExecutiveService $executiveService;

    public function __construct(LeadExecutiveService $executiveService)
    {
        $this->executiveService = $executiveService;
    }

    protected function checkAdminAccess(Request $request): void
    {
        /** @var \App\Models\LeadUser $user */
        $user = $request->user();
        if ($user->role !== 'super_admin') {
            abort(403, 'Unauthorized access. Only system administrators can perform this action.');
        }
    }

    public function index(Request $request): JsonResponse
    {
        $this->checkAdminAccess($request);
        $executives = $this->executiveService->list($request->only(['search']));

        return response()->json(LeadUserResource::collection($executives));
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $this->checkAdminAccess($request);
        $executive = $this->executiveService->find($id);
        if (!$executive || $executive->role !== 'sales_executive') {
            return response()->json(['message' => 'Executive not found.'], 404);
        }

        return response()->json(new LeadUserResource($executive));
    }

    public function store(StoreLeadExecutiveRequest $request): JsonResponse
    {
        $this->checkAdminAccess($request);
        $result = $this->executiveService->create($request->validated());

        return response()->json([
            'message'     => 'Executive account created successfully.',
            'user'        => new LeadUserResource($result['user']),
            'employee_id' => $result['user']->employee_id,
            'username'    => $result['user']->mobile,
            'password'    => $result['temporary_password'],
        ], 201);
    }

    public function update(UpdateLeadExecutiveRequest $request, int $id): JsonResponse
    {
        $this->checkAdminAccess($request);
        $executive = $this->executiveService->update($id, $request->validated());
        if (!$executive) {
            return response()->json(['message' => 'Executive not found.'], 404);
        }

        return response()->json(new LeadUserResource($executive));
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $this->checkAdminAccess($request);
        $deleted = $this->executiveService->delete($id);
        if (!$deleted) {
            return response()->json(['message' => 'Executive not found.'], 404);
        }

        return response()->json(['message' => 'Executive account deleted successfully.']);
    }

    public function resetPassword(Request $request): JsonResponse
    {
        $this->checkAdminAccess($request);
        $request->validate([
            'id' => 'required|integer|exists:lead_users,id',
        ]);

        $result = $this->executiveService->resetPassword($request->input('id'));

        return response()->json([
            'message'     => 'Password reset successfully.',
            'employee_id' => $result['employee_id'],
            'username'    => $result['username'],
            'password'    => $result['password'],
        ]);
    }
}
