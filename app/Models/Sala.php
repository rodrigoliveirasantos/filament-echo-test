<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sala extends Model {
    
    public function sessoes(): HasMany {
        return $this->hasMany(Sessao::class);
    }

}
