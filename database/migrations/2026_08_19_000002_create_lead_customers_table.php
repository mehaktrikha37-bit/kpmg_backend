<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lead_customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('executive_id')->constrained('lead_users')->onDelete('cascade');
            $table->string('name');
            $table->string('mobile');
            $table->string('email')->nullable();
            $table->string('city')->nullable();
            $table->string('company')->nullable();
            $table->string('interested_product')->nullable();
            $table->string('device_brand')->nullable();
            $table->string('device_model')->nullable();
            $table->text('customer_query')->nullable();
            $table->enum('status', ['new', 'contacted', 'follow-up', 'interested', 'purchased', 'closed'])->default('new');
            $table->date('followup_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lead_customers');
    }
};
