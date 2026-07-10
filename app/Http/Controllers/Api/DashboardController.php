<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Employee;
use App\Models\Customer;
use App\Models\Device;
use App\Models\Transfer;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function stats(Request $request)
    {
        $user = $request->user();
        $query = Device::query();
        
        if ($user->role === 'branch_manager' || $user->role === 'stock_manager') {
            $query->where('current_branch_id', $user->branch_id);
        } elseif ($user->role === 'employee') {
            $query->where('assigned_technician_id', $user->id);
        }

        $totalDevices = (clone $query)->count();
        $activeRepairs = (clone $query)->whereIn('status', ['diagnosis_in_progress', 'repair_in_progress'])->count();
        $completedRepairs = (clone $query)->where('status', 'repair_completed')->count();
        $readyForDelivery = (clone $query)->where('status', 'ready_for_delivery')->count();

        // Admin sees total system stats
        $totalBranches = $user->role === 'super_admin' ? Branch::count() : 1;
        $totalEmployees = $user->role === 'super_admin' ? Employee::count() : Employee::where('branch_id', $user->branch_id)->count();
        $totalCustomers = $user->role === 'super_admin' ? Customer::count() : Customer::where('branch_id', $user->branch_id)->count();
        
        $transferQuery = Transfer::query();
        if ($user->role !== 'super_admin') {
            $transferQuery->where(function($q) use ($user) {
                $q->where('source_branch_id', $user->branch_id)
                  ->orWhere('destination_branch_id', $user->branch_id);
            });
        }
        $devicesInTransfer = $transferQuery->where('status', 'in_transit')->count();

        return response()->json([
            'success' => true,
            'data' => [
                'totalBranches' => $totalBranches,
                'totalEmployees' => $totalEmployees,
                'totalCustomers' => $totalCustomers,
                'totalDevices' => $totalDevices,
                'activeRepairs' => $activeRepairs,
                'completedRepairs' => $completedRepairs,
                'devicesInTransfer' => $devicesInTransfer,
                'readyForDelivery' => $readyForDelivery,
            ],
            'message' => 'Dashboard stats retrieved',
        ]);
    }
}
