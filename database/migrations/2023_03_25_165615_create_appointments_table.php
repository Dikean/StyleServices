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
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->date('scheduled_date');
            $table->time('scheduled_time');

              // Estilista
              $table->unsignedBigInteger('estilista_id');
              $table->foreign('estilista_id')->references('id')->on('users')->onDelete('cascade');

               // Cliente
               $table->unsignedBigInteger('cliente_id');
               $table->foreign('cliente_id')->references('id')->on('users')->onDelete('cascade');
  
              // Servicios
              $table->unsignedBigInteger('services_id');
              $table->foreign('services_id')->references('id')->on('services')->onDelete('cascade');
              $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
