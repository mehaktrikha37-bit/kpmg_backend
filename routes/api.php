<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\ServiceReportController;
use App\Http\Controllers\Api\TransferController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\AuditLogController;
use App\Http\Controllers\Api\SettingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::post('/auth/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/profile', [AuthController::class, 'profile']);
    Route::post('/auth/change-password', [AuthController::class, 'changePassword']);

    // Dashboard
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);

    // Branches
    Route::get('/branches', [BranchController::class, 'index']);
    Route::get('/branches/{id}', [BranchController::class, 'show']);
    Route::post('/branches', [BranchController::class, 'store'])->middleware('role:super_admin');
    Route::put('/branches/{id}', [BranchController::class, 'update'])->middleware('role:super_admin');
    Route::patch('/branches/{id}/status', [BranchController::class, 'updateStatus'])->middleware('role:super_admin');

    // Employees
    Route::get('/employees', [EmployeeController::class, 'index']);
    Route::get('/employees/{id}', [EmployeeController::class, 'show']);
    Route::post('/employees', [EmployeeController::class, 'store'])->middleware('role:super_admin');
    Route::put('/employees/{id}', [EmployeeController::class, 'update'])->middleware('role:super_admin,branch_manager');
    Route::patch('/employees/{id}/status', [EmployeeController::class, 'updateStatus'])->middleware('role:super_admin');

    // Customers
    Route::get('/customers', [CustomerController::class, 'index']);
    Route::get('/customers/{id}', [CustomerController::class, 'show']);
    Route::post('/customers', [CustomerController::class, 'store']);
    Route::put('/customers/{id}', [CustomerController::class, 'update']);
    Route::get('/customers/{id}/history', [CustomerController::class, 'history']);

    // Devices (Jobs)
    Route::get('/devices', [DeviceController::class, 'index']);
    Route::get('/devices/{id}', [DeviceController::class, 'show']);
    Route::post('/devices', [DeviceController::class, 'store']);
    Route::put('/devices/{id}', [DeviceController::class, 'update']);
    Route::patch('/devices/{id}/status', [DeviceController::class, 'updateStatus']);
    Route::post('/devices/{id}/assign', [DeviceController::class, 'assignTechnician'])->middleware('role:super_admin,branch_manager');
    Route::post('/devices/{id}/notes', [DeviceController::class, 'addNote']);

    // Service Reports
    Route::get('/service-reports', [ServiceReportController::class, 'index']);
    Route::get('/service-reports/{id}', [ServiceReportController::class, 'show']);
    Route::post('/service-reports', [ServiceReportController::class, 'store']);

    // Transfers
    Route::get('/transfers', [TransferController::class, 'index']);
    Route::get('/transfers/{id}', [TransferController::class, 'show']);
    Route::post('/transfers', [TransferController::class, 'store']);
    Route::patch('/transfers/{id}/status', [TransferController::class, 'updateStatus'])->middleware('role:super_admin,branch_manager');

    // Inventory
    Route::get('/inventory', [InventoryController::class, 'index']);
    Route::get('/inventory/history', [InventoryController::class, 'history']);
    Route::post('/inventory', [InventoryController::class, 'store'])->middleware('role:super_admin,branch_manager,stock_manager');
    Route::put('/inventory/{id}', [InventoryController::class, 'update'])->middleware('role:super_admin,branch_manager,stock_manager');
    Route::post('/inventory/usage', [InventoryController::class, 'usage']);
    Route::get('/inventory/usage/device/{deviceId}', [InventoryController::class, 'usageByDevice']);

    // Audit Logs
    Route::get('/audit-logs', [AuditLogController::class, 'index'])->middleware('role:super_admin,branch_manager');

    // Settings
    Route::get('/settings', [SettingController::class, 'index']);
    Route::put('/settings', [SettingController::class, 'update'])->middleware('role:super_admin');
});
