<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $nome
 * @property string $sumario
 * @property int $duracao
 * @property string $capa
 * @property \Illuminate\Database\Eloquent\Collection<Sessao> $sessoes
 */
class Filme extends Model {
    
    public function sessoes(): HasMany {
        return $this->hasMany(Sessao::class);
    }

}
