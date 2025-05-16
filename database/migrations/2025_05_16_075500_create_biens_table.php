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
        Schema::create('biens', function (Blueprint $table) {
              $table->id('id_bien');
            $table->string('codigo_identificacion', 50)->unique();
            $table->string('nombre', 150);
            $table->text('descripcion')->nullable();
            $table->unsignedBigInteger('id_categoria')->nullable();
            $table->string('marca', 100)->nullable();
            $table->string('modelo', 100)->nullable();
            $table->string('numero_serie', 100)->nullable();
            $table->date('fecha_adquisicion')->nullable();
            $table->string('proveedor', 150)->nullable();
            $table->decimal('costo_adquisicion', 12, 2)->nullable();
            $table->unsignedBigInteger('id_ubicacion')->nullable();
            $table->enum('estado', ['Nuevo', 'Usado', 'En reparación', 'De baja', 'Obsoleto'])->default('Nuevo');
            $table->decimal('valor_actual', 12, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biens');
    }
};
