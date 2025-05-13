<?php

namespace App\Interfaces\Repositories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

interface OrderRepositoryInterface
{
    /**
     * Get all orders
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Get order by ID
     *
     * @param mixed $id
     * @return Order|null
     */
    public function getById($id): ?Order;

    /**
     * Create a new order
     *
     * @param array $data
     * @return Order
     */
    public function create(array $data): Order;

    /**
     * Update an order
     *
     * @param mixed $id
     * @param array $data
     * @return bool
     */
    public function update($id, array $data): bool;

    /**
     * Delete an order
     *
     * @param mixed $id
     * @return bool
     */
    public function delete($id): bool;

    /**
     * Get orders by user ID
     *
     * @param mixed $userId
     * @return Collection
     */
    public function getByUserId($userId): Collection;

    /**
     * Get orders by status
     *
     * @param int $status
     * @return Collection
     */
    public function getByStatus(int $status): Collection;

    /**
     * Get order with user and product
     *
     * @param mixed $id
     * @return Order|null
     */
    public function getWithRelations($id): ?Order;

    /**
     * Update order status
     *
     * @param mixed $id
     * @param int $status
     * @return bool
     */
    public function updateStatus($id, int $status): bool;
}
