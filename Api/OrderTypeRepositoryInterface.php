<?php

namespace DanielPietka\OrderType\Api;

use Magento\Sales\Model\Order;
use DanielPietka\OrderType\Api\Data\OrderTypeInterface;

interface OrderTypeRepositoryInterface
{
    /**
     * Save Order Type ID
     *
     * @param int $cartId
     * @param OrderTypeInterface $orderType
     * @return OrderTypeInterface
     */
    public function saveOrderType(int $cartId, OrderTypeInterface $orderType): OrderTypeInterface;

    /**
     * Get Order Type ID by Order
     *
     * @param Order $order
     * @return OrderTypeInterface
     */
    public function getOrderType(Order $order) : OrderTypeInterface;
}
