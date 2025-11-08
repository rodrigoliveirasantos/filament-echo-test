<?php

namespace App\Models;

use App\Enums\ReservaStatus;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;

/**
 * @property int $id
 * @property int $assento
 * @property Sessao $sessao
 * @property ?Pagamento $pagamento
 * 
 * @method static Builder withStatus(ReservaStatus $status)
 */
class Reserva extends Model {
    
    protected $casts = [
        'confirmada_em' => 'datetime',
        'cancelada_em' => 'datetime'
    ];

    public function sessao(): BelongsTo {
        return $this->belongsTo(Sessao::class);
    }

    public function pagamento(): BelongsTo {
        return $this->belongsTo(Pagamento::class);
    }

    public function status(): ReservaStatus {
        return match(true) {
            filled($this->cancelada_em) => ReservaStatus::Cancelada,
            filled($this->confirmada_em) => ReservaStatus::Cancelada,
            default => ReservaStatus::AguardandoConfirmacao,
        };
    }

    protected function scopeWithStatus(Builder $query, array|Arrayable|ReservaStatus $statuses): void {
        if ($statuses instanceof Arrayable) {
            $statuses = $statuses->toArray();
        } else {
            $statuses = Arr::wrap($statuses);
        }

        collect($statuses)->values()->each(function (ReservaStatus $status, int $i) use ($query) {
            $boolean = $i === 0 ? 'and' : 'or';
            $query->where(function (Builder $query) use ($status) {
                match($status) {
                    ReservaStatus::Cancelada => $query->whereNotNull('cancelada_em'),
                    ReservaStatus::Confirmada => $query->whereNotNull('confirmada_em')->whereNull('cancelada_em'),
                    default => $query->whereNull('confirmada_em')->whereNull('cancelada_em')
                };
            }, boolean: $boolean);
        });
        
    }

    protected function scopeWithoutCanceladas(Builder $query): void {
        $query->withStatus([ReservaStatus::Confirmada, ReservaStatus::AguardandoConfirmacao]);
    }
}
