<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained('devices')->onDelete('cascade');
            $table->string('job_number');
            $table->unsignedBigInteger('customer_id');
            $table->string('customer_name');
            $table->string('customer_mobile', 15);
            $table->text('customer_address')->nullable();
            $table->string('device_type');
            $table->string('brand');
            $table->string('model');
            $table->string('serial_number')->nullable();
            $table->timestamp('call_received_date')->nullable();
            $table->timestamp('call_attended_date')->nullable();
            $table->timestamp('call_completed_date')->nullable();
            $table->enum('call_type', ['warranty', 'out_warranty', 'amc'])->default('out_warranty');
            $table->enum('service_type', ['onsite', 'carry_in', 'one_hour'])->default('carry_in');
            $table->text('problem_description');
            $table->json('accessories_received')->nullable();
            $table->text('action_taken')->nullable();
            $table->text('rectification_details')->nullable();
            $table->text('engineer_remarks')->nullable();
            $table->decimal('estimate_amount', 10, 2)->nullable();
            $table->enum('call_status', ['completed', 'pending_spare', 'pending_technical_support', 'customer_confirmation', 'other'])->default('pending_spare');
            $table->longText('customer_signature')->nullable();
            $table->longText('employee_signature')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('branch_id');
            $table->string('branch_name')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_reports');
    }
};
