<?php

namespace App\Enums;

enum OrderItemType: string
{
    case PIZZA = 'pizza';
    case SLICE = 'slice';
    case DRINK = 'drink';
    case APPETIZER = 'appetizer';
    case COOKIE = 'cookie';
}
