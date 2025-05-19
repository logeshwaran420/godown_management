<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movements', function (Blueprint $table) {
           $table->id();
    $table->date('date');
    $table->foreignId('from_warehouse_id')->constrained('warehouses')->onDelete('cascade');
    $table->foreignId('to_warehouse_id')->constrained('warehouses')->onDelete('cascade');
    $table->integer('total_quantity')->default(0); // Add this line
    $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movements');
    }
};
