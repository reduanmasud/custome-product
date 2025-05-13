<?php

namespace App\Interfaces\Services;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface OrderServiceInterface
{
    /**
     * Get all orders
     *
     * @return Collection
     */
    public function getAllOrders(): Collection;

    /**
     * Get order by ID
     *
     * @param mixed $id
     * @return Order|null
     */
    public function getOrderById($id): ?Order;

    /**
     * Create a new order
     *
     * @param Request $request
     * @return Order
     */
    public function createOrder(Request $request): Order;

    /**
     * Update an order
     *
     * @param mixed $id
     * @param Request $request
     * @return bool
     */
    public function updateOrder($id, Request $request): bool;

    /**
     * Update order status
     *
     * @param mixed $id
     * @param int $status
     * @return bool
     */
    public function updateOrderStatus($id, int $status): bool;

    /**
     * Delete an order
     *
     * @param mixed $id
     * @return bool
     */
    public function deleteOrder($id): bool;
}
