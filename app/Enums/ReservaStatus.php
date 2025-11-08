<?php

namespace App\Enums;

enum ReservaStatus: int {
    case AguardandoConfirmacao = 0;
    case Confirmada = 1;
    case Cancelada = 2;
}