<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained('devices')->onDelete('cascade');
            $table->string('job_number');
            $table->foreignId('stock_item_id')->constrained('stock_items')->onDelete('cascade');
            $table->string('item_name');
            $table->integer('quantity')->default(1);
            $table->decimal('selling_price', 10, 2)->default(0);
            $table->unsignedBigInteger('added_by')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->timestamp('used_at')->nullable();
            $table->timestamps();

            $table->foreign('added_by')->references('id')->on('employees')->nullOnDelete();
            $table->foreign('branch_id')->references('id')->on('branches')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_usages');
    }
};
