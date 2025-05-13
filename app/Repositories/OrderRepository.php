<?php

namespace App\Repositories;

use App\Interfaces\Repositories\OrderRepositoryInterface;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository implements OrderRepositoryInterface
{
    /**
     * Get all orders
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Order::all();
    }

    /**
     * Get order by ID
     *
     * @param mixed $id
     * @return Order|null
     */
    public function getById($id): ?Order
    {
        return Order::find($id);
    }

    /**
     * Create a new order
     *
     * @param array $data
     * @return Order
     */
    public function create(array $data): Order
    {
        return Order::create($data);
    }

    /**
     * Update an order
     *
     * @param mixed $id
     * @param array $data
     * @return bool
     */
    public function update($id, array $data): bool
    {
        $order = $this->getById($id);
        
        if (!$order) {
            return false;
        }
        
        return $order->update($data);
    }

    /**
     * Delete an order
     *
     * @param mixed $id
     * @return bool
     */
    public function delete($id): bool
    {
        $order = $this->getById($id);
        
        if (!$order) {
            return false;
        }
        
        return $order->delete();
    }

    /**
     * Get orders by user ID
     *
     * @param mixed $userId
     * @return Collection
     */
    public function getByUserId($userId): Collection
    {
        return Order::where('user_id', $userId)->get();
    }

    /**
     * Get orders by status
     *
     * @param int $status
     * @return Collection
     */
    public function getByStatus(int $status): Collection
    {
        return Order::where('status', $status)->get();
    }

    /**
     * Get order with user and product
     *
     * @param mixed $id
     * @return Order|null
     */
    public function getWithRelations($id): ?Order
    {
        return Order::with(['user', 'product'])->find($id);
    }

    /**
     * Update order status
     *
     * @param mixed $id
     * @param int $status
     * @return bool
     */
    public function updateStatus($id, int $status): bool
    {
        $order = $this->getById($id);
        
        if (!$order) {
            return false;
        }
        
        return $order->update(['status' => $status]);
    }
}
