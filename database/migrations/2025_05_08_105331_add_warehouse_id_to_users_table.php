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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('warehouse_id')->nullable(); // Adding warehouse_id column
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('set null'); // Foreign key to the warehouses table
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['warehouse_id']); // Drop the foreign key constraint
            $table->dropColumn('warehouse_id'); // Drop the warehouse_id column
        });
    }
};
