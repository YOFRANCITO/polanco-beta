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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('socio_id')->constrained('socios')->onDelete('cascade');
            $table->string('concepto')->default('Cuota Mensual de Membresía');
            $table->decimal('monto', 10, 2);
            $table->string('metodo')->default('qr'); // qr, tarjeta, transferencia, efectivo
            $table->string('estado')->default('completado'); // completado, pendiente, rechazado
            $table->string('referencia')->nullable()->unique();
            $table->string('comprobante')->nullable();
            $table->date('fecha_pago')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
