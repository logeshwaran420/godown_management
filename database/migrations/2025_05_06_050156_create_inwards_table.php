<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;



return new class extends Migration
{
      protected $model = Inward::class;
      
        public function up(): void
    {
 
        Schema::create('inwards', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('ledger_id')->constrained()->onDelete('cascade');
            $table->foreignId('warehouse_id')->constrained()->onDelete('cascade');
            $table->string('invoice_no')->nullable();
           $table->integer('total_quantity')->default(0);
           $table->decimal('total_amount', 12, 2)->default(0);
           
            $table->timestamps();
        });
        
    }    
    public function down(): void
    {
        Schema::dropIfExists('inwards');
    }
   
};