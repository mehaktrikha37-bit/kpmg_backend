<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lead_users', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->unique();
            $table->string('name');
            $table->string('mobile')->unique();
            $table->string('email')->nullable()->unique();
            $table->string('password');
            $table->enum('role', ['super_admin', 'sales_executive']);
            $table->string('branch');
            $table->string('designation')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->boolean('is_temp_password')->default(true);
            $table->string('temp_password')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lead_users');
    }
};
