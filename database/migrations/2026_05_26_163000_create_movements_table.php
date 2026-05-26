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
            $table->foreignId('warehouse_id'); // ID del almacén implicado [cite: 54]
            $table->foreignId('product_id');   // ID del producto [cite: 54]
            $table->foreignId('user_id');      // ID del usuario que registra el movimiento
            $table->string('type');            // 'entrada' o 'salida' [cite: 54]
            $table->integer('quantity');       // Cantidad de productos [cite: 54]
            
            // COLUMNA CORRECTA: Guarda el estado del flujo de aprobación (Punto 8)
            $table->string('status')->default('pendiente'); 
            
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