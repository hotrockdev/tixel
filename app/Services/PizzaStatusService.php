<?php

namespace App\Services;

use App\Events\OrderItemUpdated;
use App\Models\OrderItems;

class PizzaStatusService
{
    public function initSelectedStatus($orders)
    {
        //Init the array
        $selected_statuses = [];

        foreach ($orders->pluck('order_items')->flatten(1) as $order_item) {
            $selected_statuses[$order_item->id] = null;
        }

        return $selected_statuses;
    }

    public function updateItemStatus(OrderItems $order_item, $value)
    {
        $order_item->status = $value;
        $order_item->updated_at = now();
        $order_item->save();

        return $order_item;
    }
}
