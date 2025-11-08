<?php

use App\Models\Filme;
use App\Models\Sala;
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
        Schema::create('sessoes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Filme::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Sala::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->dateTime('data', 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessoes');
    }
};
