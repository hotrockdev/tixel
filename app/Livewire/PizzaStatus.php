<?php

namespace App\Livewire;

use App\Enums\OrderItemStatus;
use App\Events\OrderItemUpdated;
use App\Models\Order;
use App\Models\OrderItems;
use App\Services\PizzaStatusService;
use Livewire\Component;

class PizzaStatus extends Component
{
    public $orders;
    public $statuses;
    public $selected_statuses;

    protected $service;

    public function boot(PizzaStatusService $service)
    {
        $this->service = $service;
    }

    public function mount()
    {
        $this->orders = Order::with('order_items')->orderBy('id')->get();
        $this->statuses = OrderItemStatus::cases();
        $this->selected_statuses = $this->service->initSelectedStatus($this->orders);
    }

    public function setItemStatus($value, $id)
    {
        //Pull the item from the order
        $order_item = OrderItems::find($id);

        //Update the status
        $order_item = $this->service->updateItemStatus($order_item, $value);

        // Dispatch the event
        if(!empty($order_item)) { event(new OrderItemUpdated($order_item)); }
    }

    public function render()
    {
        return view('livewire.pizza-status');
    }
}
