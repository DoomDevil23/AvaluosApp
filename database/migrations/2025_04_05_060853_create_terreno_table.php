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
        Schema::create('terreno', function (Blueprint $table) {
            $table->id();
            $table->timestamp('fechaInscripcion');
            $table->string('tituloFinca');
            $table->double('areaTerreno', 10, 2);
            $table->double('valorTerreno', 10, 2);
            $table->double('valorMejora', 10, 2);
            //$table->double('valorTraspaso', 10, 2); se calcula con los 2 campos anteriores
            //$table->double('valorTerrenoM2', 10, 2);se calcula dividiendo el campo valorTerreno entre areaTerreno
            //$table->double('valorMejoraM2', 10, 2);se calcula dividiendo el (valorTerreno+valorMejora) entre areaTerreno
            $table->unsignedBigInteger('idTipoMejora');
            $table->foreign('idTipoMejora')->references('id')->on('tipoMejora')->onDelete('cascade');
            $table->unsignedBigInteger('idComunidad');
            $table->foreign('idComunidad')->references('id')->on('comunidades')->onDelete('cascade');
            $table->string('zona')->nullable();//ubicacion gps del terreno
            $table->string('lote')->nullable();
            $table->string('planoLote')->nullable();//ubicacion del archivo pdf
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terreno');
    }
};
