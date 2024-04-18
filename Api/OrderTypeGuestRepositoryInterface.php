<?php

namespace DanielPietka\OrderType\Api;

use DanielPietka\OrderType\Api\Data\OrderTypeInterface;

interface OrderTypeGuestRepositoryInterface
{
    /**
     * Save Order Type ID
     *
     * @param string $cartId
     * @param OrderTypeInterface $orderType
     * @return OrderTypeInterface
     */
    public function saveOrderType(string $cartId, OrderTypeInterface $orderType): OrderTypeInterface;
}
