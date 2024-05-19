<?php

namespace App\Enums;

enum OrderItemStatus: string
{
    case ORDERED = 'ordered';
    case STARTED = 'started';
    case COOKING = 'cooking';
    case COMPLETED = 'completed';
}
