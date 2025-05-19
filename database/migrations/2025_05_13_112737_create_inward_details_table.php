<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inward_details', function (Blueprint $table) {
            $table->id();
    $table->foreignId('inward_id')->constrained()->onDelete('cascade');
    $table->foreignId('item_id')->constrained()->onDelete('cascade');
    $table->integer('quantity');
    $table->decimal('price', 10, 2);
    $table->decimal('total_amount', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inward_details');
    }
};
