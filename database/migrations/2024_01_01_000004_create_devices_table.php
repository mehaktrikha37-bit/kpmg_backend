<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('job_number')->unique();
            $table->string('receipt_number')->unique();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->string('customer_name');
            $table->string('customer_mobile', 15);
            $table->enum('type', ['laptop', 'desktop', 'printer', 'networking', 'other'])->default('laptop');
            $table->string('brand');
            $table->string('model');
            $table->string('serial_number')->nullable();
            $table->string('processor')->nullable();
            $table->string('ram')->nullable();
            $table->string('storage')->nullable();
            $table->json('accessories')->nullable();
            $table->text('reported_issue');
            $table->text('physical_condition')->nullable();
            $table->json('condition_checklist')->nullable();
            $table->foreignId('current_branch_id')->constrained('branches')->onDelete('cascade');
            $table->string('current_branch_name')->nullable();
            $table->unsignedBigInteger('assigned_technician_id')->nullable();
            $table->string('assigned_technician_name')->nullable();
            $table->enum('status', [
                'received', 'assigned', 'diagnosis_in_progress', 'repair_in_progress',
                'transfer_required', 'transferred', 'repair_completed',
                'ready_for_delivery', 'delivered', 'closed'
            ])->default('received');
            $table->string('call_type')->nullable();
            $table->string('service_type')->nullable();
            $table->string('call_reason')->nullable();
            $table->string('response_time')->nullable();
            $table->string('error_codes')->nullable();
            $table->date('doi')->nullable();
            $table->longText('customer_signature')->nullable();
            $table->longText('employee_signature')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('assigned_technician_id')->references('id')->on('employees')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('employees')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
