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
        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('dni')->unique();
            $table->string('telefono')->nullable();
            $table->string('email')->unique();
            $table->string('seguridad_social')->unique()->nullable();
            $table->text('cuenta_bancaria')->nullable();
            $table->text('observaciones')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workers');
    }
};
