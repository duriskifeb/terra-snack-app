<?php

namespace App\Livewire\CustomerHistory;

use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.customer')]
class CustomerHistoryDetailPage extends Component
{
    public Order $order;

    public function mount($orderId)
    {
        $this->order = Order::with(['items.product'])
            ->where('id', $orderId)
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.customer-history.customer-history-detail-page');
    }
}
