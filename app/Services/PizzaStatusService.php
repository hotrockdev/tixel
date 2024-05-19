<?php

namespace App\Services;

use App\Events\OrderItemUpdated;
use App\Models\OrderItems;

class PizzaStatusService
{
    public function initSelectedStatus($orders)
    {
        //Init the array
        $selected_status = [];

        foreach ($orders as $order)
        {
            foreach($order->order_items as $i) { $selected_statuses[$i->id] = null; }
        }

        return $selected_status;
    }

    public function updateItemStatus(OrderItems $order_item, $value)
    {
        $order_item->status = $value;
        $order_item->updated_at = now();
        $order_item->save();

        return $order_item;
    }
}
