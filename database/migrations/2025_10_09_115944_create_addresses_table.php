<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // Relación con el trabajador
            $table->foreignId('worker_id')
                  ->constrained('workers')
                  ->onDelete('cascade');

            // Campos de dirección
            $table->string('street')->nullable();       // Calle y número
            $table->string('city')->nullable();         // Ciudad o pueblo
            $table->string('province')->nullable();     // Provincia
            $table->string('postal_code')->nullable();  // Código postal
            $table->string('country')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
