<?php

use App\Models\Pagamento;
use App\Models\Sessao;
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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Sessao::class);
            $table->unsignedSmallInteger('assento');
            $table->timestamp('confirmada_em')->nullable();
            $table->timestamp('cancelada_em')->nullable();
            $table->foreignIdFor(Pagamento::class)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
