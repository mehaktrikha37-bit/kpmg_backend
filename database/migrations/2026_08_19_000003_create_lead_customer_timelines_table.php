<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lead_customer_timelines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('lead_customers')->onDelete('cascade');
            $table->string('action');
            $table->text('remarks')->nullable();
            $table->foreignId('created_by')->constrained('lead_users')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lead_customer_timelines');
    }
};
