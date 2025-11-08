<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property Filme $filme
 * @property Sala $sala
 * @property \Carbon\Carbon $horario
 */
class Sessao extends Model {
    
    protected $table = 'sessoes';

    protected $casts = [
        'horario' => 'datetime'
    ];

    public function filme(): BelongsTo {
        return $this->belongsTo(Filme::class);
    }

    public function sala(): BelongsTo {
        return $this->belongsTo(Sala::class);
    }

    public function reservas(): HasMany {
        return $this->hasMany(Reserva::class);
    }

    public function vagasRestantes(): int {
        $reservas = $this->reservas()->withoutCanceladas()->count();
        $capacidadeDaSala = $this->sala->capacidade;
        return max($capacidadeDaSala - $reservas, 0); // CASO dê menos que 0, eu fiz alguma merda. Mas so pra garantir.
    }

    public function isLotada(): bool {
        return $this->vagasRestantes() === 0;
    }

}
