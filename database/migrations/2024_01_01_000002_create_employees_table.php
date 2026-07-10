<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('mobile', 15)->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('designation');
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade');
            $table->string('branch_name')->nullable();
            $table->enum('role', ['super_admin', 'branch_manager', 'employee', 'stock_manager'])->default('employee');
            $table->boolean('is_active')->default(true);
            $table->boolean('must_change_password')->default(true);
            $table->boolean('is_first_login')->default(true);
            $table->integer('assigned_devices')->default(0);
            $table->integer('completed_jobs')->default(0);
            $table->string('avatar_url')->nullable();
            $table->timestamp('joined_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // Add foreign key for manager_id on branches after employees table exists
        Schema::table('branches', function (Blueprint $table) {
            $table->foreign('manager_id')->references('id')->on('employees')->nullOnDelete();
        });

        // Personal access tokens table for Sanctum
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->dropForeign(['manager_id']);
        });
        Schema::dropIfExists('personal_access_tokens');
        Schema::dropIfExists('employees');
    }
};
