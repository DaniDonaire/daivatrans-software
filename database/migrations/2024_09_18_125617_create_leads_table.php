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
        Schema::create('leads', function (Blueprint $table) {

            $table->id();
            $table->string('name')->nullable();        
            $table->string('email')->unique(); 
            $table->string('phone')->nullable();   
            $table->date('contact_date')->nullable();       

            $table->unsignedBigInteger('service_id')->nullable(); 
            $table->foreign('service_id')->references('id')->on('services')->onDelete('set null');            

            $table->unsignedBigInteger('contact_method_id')->nullable(); 
            $table->foreign('contact_method_id')->references('id')->on('contact_methods')->onDelete('set null');            

            $table->unsignedBigInteger('status_id')->nullable(); 
            $table->foreign('status_id')->references('id')->on('status')->onDelete('set null');            

            $table->unsignedBigInteger('user_id')->nullable(); 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');            


            $table->timestamps();  

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
