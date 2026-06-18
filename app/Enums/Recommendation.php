<?php

namespace App\Enums;

enum Recommendation: string
{
    case Convoquer = 'convoquer';
    case Attente = 'attente';
    case Rejeter = 'rejeter';
}
