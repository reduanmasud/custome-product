<?php

namespace App\Services;

use App\Interfaces\Services\OrderServiceInterface;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class OrderService implements OrderServiceInterface
{
    /**
     * Get all orders
     *
     * @return Collection
     */
    public function getAllOrders(): Collection
    {
        return Order::with(['user', 'product'])->get();
    }

    /**
     * Get order by ID
     *
     * @param mixed $id
     * @return Order|null
     */
    public function getOrderById($id): ?Order
    {
        return Order::with(['user', 'product'])->find($id);
    }

    /**
     * Create a new order
     *
     * @param Request $request
     * @return Order
     */
    public function createOrder(Request $request): Order
    {
        return Order::create([
            'user_id' => $request->user_id ?? auth()->id(),
            'product_id' => $request->product_id,
            'quantity' => $request->quantity ?? 1,
            'total_price' => $request->total_price,
            'status' => $request->status ?? 0, // Default to pending
            'shipping_address' => $request->shipping_address,
            'payment_method' => $request->payment_method,
            'payment_status' => $request->payment_status ?? 0, // Default to unpaid
            'notes' => $request->notes,
        ]);
    }

    /**
     * Update an order
     *
     * @param mixed $id
     * @param Request $request
     * @return bool
     */
    public function updateOrder($id, Request $request): bool
    {
        $order = $this->getOrderById($id);

        if (!$order) {
            return false;
        }

        return $order->update([
            'user_id' => $request->user_id ?? $order->user_id,
            'product_id' => $request->product_id ?? $order->product_id,
            'quantity' => $request->quantity ?? $order->quantity,
            'total_price' => $request->total_price ?? $order->total_price,
            'status' => $request->status ?? $order->status,
            'shipping_address' => $request->shipping_address ?? $order->shipping_address,
            'payment_method' => $request->payment_method ?? $order->payment_method,
            'payment_status' => $request->payment_status ?? $order->payment_status,
            'notes' => $request->notes ?? $order->notes,
        ]);
    }

    /**
     * Update order status
     *
     * @param mixed $id
     * @param int $status
     * @return bool
     */
    public function updateOrderStatus($id, int $status): bool
    {
        $order = $this->getOrderById($id);

        if (!$order) {
            return false;
        }

        return $order->update([
            'status' => $status,
        ]);
    }

    /**
     * Delete an order
     *
     * @param mixed $id
     * @return bool
     */
    public function deleteOrder($id): bool
    {
        $order = $this->getOrderById($id);

        if (!$order) {
            return false;
        }

        return $order->delete();
    }
}
