<?php

namespace App\Enums;

enum Recommendation: string

{
    case CONVOQUER = 'convoquer';
    case ATTENTE = 'attente';
    case REJETER = 'rejeter';
}