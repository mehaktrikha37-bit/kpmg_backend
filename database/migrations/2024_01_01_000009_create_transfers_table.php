<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->string('transfer_number')->unique();
            $table->unsignedBigInteger('source_branch_id');
            $table->string('source_branch_name')->nullable();
            $table->unsignedBigInteger('destination_branch_id');
            $table->string('destination_branch_name')->nullable();
            $table->foreignId('device_id')->constrained('devices')->onDelete('cascade');
            $table->string('job_number');
            $table->string('device_info')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->enum('reason', ['motherboard_repair', 'chip_level_repair', 'expertise_unavailable', 'spare_unavailable', 'warranty_processing', 'other'])->default('other');
            $table->string('reason_other')->nullable();
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('requested_by_id')->nullable();
            $table->string('requested_by_name')->nullable();
            $table->unsignedBigInteger('approved_by_id')->nullable();
            $table->string('approved_by_name')->nullable();
            $table->unsignedBigInteger('received_by_id')->nullable();
            $table->string('received_by_name')->nullable();
            $table->enum('status', ['pending', 'approved', 'in_transit', 'received', 'cancelled'])->default('pending');
            $table->timestamp('requested_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('dispatched_at')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamps();

            $table->foreign('source_branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('destination_branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->nullOnDelete();
            $table->foreign('requested_by_id')->references('id')->on('employees')->nullOnDelete();
            $table->foreign('approved_by_id')->references('id')->on('employees')->nullOnDelete();
            $table->foreign('received_by_id')->references('id')->on('employees')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
