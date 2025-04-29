<?php

namespace App\Enums;

use App\Traits\Listable;

enum Religion: string
{
    use Listable;
    
    case ROMAN_CATHOLIC = 'Roman Catholic';
    case BORN_AGAIN = 'Born Again';
    case INC = 'INC';
    case MUSLIM = 'Muslim';
    case ADVENTIST = 'Adventist';
    case OTHERS = 'Others';
}