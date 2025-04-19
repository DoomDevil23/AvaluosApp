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
        Schema::create('corregimientos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('idDistrito');
            $table->foreign('idDistrito')->references('id')->on('distritos')->onDelete('cascade');
            $table->string('codigoUbicacion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corregimientos');
    }
};
