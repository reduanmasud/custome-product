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
     * @param int $id
     * @return Order|null
     */
    public function getOrderById(int $id): ?Order;

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
     * @param int $id
     * @param Request $request
     * @return bool
     */
    public function updateOrder(int $id, Request $request): bool;

    /**
     * Update order status
     *
     * @param int $id
     * @param int $status
     * @return bool
     */
    public function updateOrderStatus(int $id, int $status): bool;

    /**
     * Delete an order
     *
     * @param int $id
     * @return bool
     */
    public function deleteOrder(int $id): bool;
}
