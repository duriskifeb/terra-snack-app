<?php

namespace App\Livewire\CustomerHistory;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Collection;

#[Layout('components.layouts.customer')]
class CustomerHistoryPage extends Component
{
    public Collection $orders;
    public int $page = 1;
    public int $perPage = 2;
    public bool $hasMorePages = true;
    public bool $loading = false;

    protected $listeners = ['loadMore' => 'loadMore'];

    public function mount()
    {
        $this->orders = collect();
        $this->loadOrders();
    }

    public function loadMore()
    {
        if ($this->loading || !$this->hasMorePages) return;

        $this->loading = true;
        $this->page++;
        $this->loadOrders();
    }

    private function loadOrders()
    {
        $user = User::find(1); 
        if (!$user) {
            $this->hasMorePages = false;
            $this->loading = false;
            return;
        }

        $skip = ($this->page - 1) * $this->perPage;

        $orders = $user->orders()
            ->orderByDesc('id')
            ->skip($skip)
            ->take($this->perPage)
            ->get();

        $this->orders = $this->orders->concat($orders);
        $this->hasMorePages = $orders->count() === $this->perPage;
        $this->loading = false;
    }

    public function render()
    {
        return view('livewire.customer-history.customer-history-page', [
            'orders' => $this->orders,
            'hasMorePages' => $this->hasMorePages,
        ]);
    }
}
