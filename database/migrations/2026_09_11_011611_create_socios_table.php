<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('socios', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_acceso', 20)->unique();   // Código para acceso del socio
            $table->string('nombre');
            $table->string('apellido');
            $table->string('email')->nullable();
            $table->string('telefono', 30)->nullable();
            $table->date('fecha_nacimiento');
            $table->string('cedula', 20)->nullable()->unique();
            $table->enum('categoria', ['familiar', 'individual', 'junior', 'vip'])->default('individual');
            $table->enum('estado', ['activo', 'inactivo', 'moroso'])->default('activo');
            $table->decimal('cuota_mensual', 10, 2)->default(0);
            $table->date('fecha_ingreso');
            $table->date('fecha_vencimiento')->nullable();
            $table->string('foto')->nullable();
            $table->string('direccion')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('socios');
    }
};
