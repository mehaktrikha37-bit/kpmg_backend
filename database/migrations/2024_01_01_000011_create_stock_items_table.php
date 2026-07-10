<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_items', function (Blueprint $table) {
            $table->id();
            $table->string('item_code')->unique();
            $table->string('name');
            $table->string('part_number')->nullable();
            $table->string('category');
            $table->string('compatible_devices')->nullable();
            $table->string('brand')->nullable();
            $table->integer('quantity')->default(0);
            $table->integer('reorder_level')->nullable();
            $table->decimal('unit_cost', 10, 2)->default(0);
            $table->decimal('selling_price', 10, 2)->default(0);
            $table->string('supplier')->nullable();
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade');
            $table->string('branch_name')->nullable();
            $table->string('location')->nullable();
            $table->string('warranty')->nullable();
            $table->string('condition')->nullable(); // New / Refurbished / Used
            $table->string('unit')->default('pcs');
            $table->string('slip_photo_path')->nullable();
            $table->string('slip_number')->nullable();
            $table->unsignedBigInteger('added_by')->nullable();
            $table->timestamps();

            $table->foreign('added_by')->references('id')->on('employees')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_items');
    }
};
