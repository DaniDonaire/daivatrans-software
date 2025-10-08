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

            $table->string('name');
            $table->string('surname');
            $table->string('dni', 9)->unique();
            $table->string('telefono', 15)->nullable();
            $table->string('email')->unique();
            $table->string('seguridad_social', 12)->unique();
            $table->text('cuenta_bancaria');
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
