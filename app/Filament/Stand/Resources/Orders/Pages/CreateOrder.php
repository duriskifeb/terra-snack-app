<?php

namespace App\Filament\Stand\Resources\Orders\Pages;

use App\Filament\Stand\Resources\Orders\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Simpan items untuk diproses nanti
        $this->cachedItems = $data['items'] ?? [];
        
        // Hitung total price dari semua items jika belum diisi
        if (empty($data['total_price']) && !empty($this->cachedItems)) {
            $totalPrice = 0;
            foreach ($this->cachedItems as $item) {
                $totalPrice += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
            }
            $data['total_price'] = $totalPrice;
        }

        // Set default values untuk order
        $data['user_id'] = auth()->id();
        $data['status'] = $data['status'] ?? 'pending';
        $data['payment_status'] = $data['payment_status'] ?? 'unpaid';
        $data['gross_amount'] = $data['total_price'];
        $data['packaging_fee_per_item'] = 0;
        $data['packaging_fee_total'] = 0;

        // Simpan payment method untuk cek nanti
        $this->paymentMethod = $data['payment_method'] ?? 'cash';

        // Hapus items dari data karena bukan field di table orders
        unset($data['items']);

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        $order = parent::handleRecordCreation($data);

        if (!empty($this->cachedItems)) {
            foreach ($this->cachedItems as $item) {
                $productName = $this->generateProductName($item);
                $unitPrice = $item['price'] ?? 0;
                $quantity = $item['quantity'] ?? 1;
                $subtotal = $unitPrice * $quantity;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => null,
                    'product_name' => $productName,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ]);
            }
        }

        return $order;
    }

    protected function afterCreate(): void
    {
        $order = $this->getRecord();

        // Jika payment method QRIS, tampilkan modal
        if ($this->paymentMethod === 'qris') {
            $this->halt();
            $this->mountAction('confirmQrisPayment');
        } else {
            // Redirect langsung untuk payment method lain
            Notification::make()
                ->title('Pesanan berhasil dibuat!')
                ->success()
                ->send();
        }
    }

    protected function getActions(): array
    {
        return [
            Action::make('confirmQrisPayment')
                ->modalHeading('Scan QRIS untuk Pembayaran')
                ->modalDescription(function () {
                    $order = $this->getRecord();
                    return 'Total Pembayaran: Rp ' . number_format($order?->total_price ?? 0, 0, ',', '.');
                })
                ->modalContent(function () {
                    $order = $this->getRecord();
                    return view('filament.pages.qris-payment', [
                        'order_id' => $order?->id ?? 0,
                        'total' => $order?->total_price ?? 0,
                    ]);
                })
                ->modalSubmitActionLabel('Sudah Scan & Bayar')
                ->modalCancelActionLabel('Batalkan')
                ->modalWidth('lg')
                ->action(function () {
                    // Update order status menjadi paid
                    $order = $this->getRecord();
                    
                    if ($order) {
                        $order->update([
                            'payment_status' => 'paid',
                            'paid_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Pembayaran QRIS berhasil!')
                            ->success()
                            ->send();
                    }
                })
                ->closeModalByClickingAway(false),
        ];
    }

    protected function generateProductName(array $item): string
    {
        $type = $item['product_type'] ?? 'Item';
        
        if ($type === 'snack') {
            $parts = [ucfirst($type)];
            
            if (!empty($item['vegetable']) && $item['vegetable'] !== 'none') {
                $parts[] = ucfirst($item['vegetable']);
            }
            
            if (!empty($item['topping']) && $item['topping'] !== 'none') {
                $parts[] = ucfirst($item['topping']);
            }
            
            if (!empty($item['sauce']) && $item['sauce'] !== 'none') {
                $parts[] = ucfirst($item['sauce']);
            }
            
            return implode(' - ', $parts);
        }
        
        return ucfirst($type);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    private array $cachedItems = [];
    private string $paymentMethod = 'cash';
}