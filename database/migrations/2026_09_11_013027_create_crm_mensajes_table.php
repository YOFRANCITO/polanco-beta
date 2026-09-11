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
        Schema::create('crm_mensajes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('socio_id')->nullable()->constrained('socios')->nullOnDelete();
            $table->string('tipo')->default('recordatorio_pago'); // recordatorio_pago, cumpleanos, bienvenida, aviso
            $table->string('canal')->default('whatsapp');
            $table->string('telefono');
            $table->text('mensaje');
            $table->string('estado')->default('enviado'); // enviado, programado, pendiente
            $table->timestamp('fecha_envio')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crm_mensajes');
    }
};
