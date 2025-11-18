<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.customer')] 
class UploadPaymentProof extends Component
{
    use WithFileUploads;
    public Order $order;
    public $paymentProof;

    public function mount(Order $order)
    {
        $this->order = $order;
    }

    public function uploadPaymentProof()
    {
        $this->validate([
            'paymentProof' => 'required|image|max:2048',
        ]);

        $path = $this->paymentProof->store('payment_proofs', 'public');

        $this->order->update([
            'payment_proof' => $path,
            'payment_status' => 'paid',
            'paid_at' => now(),
        ]);

        session()->flash('success', 'Bukti pembayaran berhasil di-upload!');
        return redirect()->route('customer-history.detail', $this->order->id);
    }

    public function render()
    {
        return view('livewire.upload-payment-proof');
    }
}
