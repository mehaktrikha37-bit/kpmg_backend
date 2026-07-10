<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Models\Employee;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\AuditService;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with('branch');
        
        $user = $request->user();
        if ($user->role !== 'super_admin') {
            $query->where('branch_id', $user->branch_id);
        }

        if ($request->has('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        $employees = $query->orderBy('name', 'asc')->get();

        return response()->json([
            'success' => true,
            'data' => $employees,
            'message' => 'Employees retrieved',
        ]);
    }

    public function show($id)
    {
        $employee = Employee::with('branch')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $employee,
            'message' => 'Employee retrieved',
        ]);
    }

    public function store(StoreEmployeeRequest $request)
    {
        $data = $request->validated();
        
        $branch = Branch::findOrFail($data['branch_id']);
        $data['branch_name'] = $branch->name;
        
        $password = $request->password ?? 'User@123';
        $data['password'] = Hash::make($password);
        $data['joined_at'] = now();

        $employee = Employee::create($data);
        
        $branch->increment('total_employees');
        
        AuditService::log('create', 'employee', $employee->id, Employee::class);

        return response()->json([
            'success' => true,
            'data' => $employee,
            'message' => 'Employee created successfully',
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        
        // Custom validation logic because of unique constraint ignoring self
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15|unique:employees,mobile,' . $id,
            'email' => 'required|email|max:255|unique:employees,email,' . $id,
            'designation' => 'required|string|max:255',
            'role' => 'required|in:super_admin,branch_manager,employee,stock_manager',
        ]);

        $data = $request->all();

        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
            $data['must_change_password'] = true;
        } else {
            unset($data['password']);
        }

        if (isset($data['branch_id']) && $data['branch_id'] != $employee->branch_id) {
            $branch = Branch::findOrFail($data['branch_id']);
            $data['branch_name'] = $branch->name;
            
            // Update branch employee counts
            Branch::find($employee->branch_id)->decrement('total_employees');
            $branch->increment('total_employees');
        }

        $employee->update($data);
        AuditService::log('update', 'employee', $employee->id, Employee::class);

        return response()->json([
            'success' => true,
            'data' => $employee,
            'message' => 'Employee updated successfully',
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['is_active' => 'required|boolean']);
        
        $employee = Employee::findOrFail($id);
        $employee->is_active = $request->is_active;
        $employee->save();

        // If deactivated, revoke all tokens
        if (!$employee->is_active) {
            $employee->tokens()->delete();
        }

        AuditService::log('update_status', 'employee', $employee->id, Employee::class, 'Status changed to ' . ($employee->is_active ? 'Active' : 'Inactive'));

        return response()->json([
            'success' => true,
            'data' => $employee,
            'message' => 'Employee status updated',
        ]);
    }
}
