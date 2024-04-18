<?php

namespace DanielPietka\OrderType\Api\Data;

interface OrderTypeInterface
{
    public const TYPE_ID = 'order_type_id';

    /**
     * Get Order Type ID
     *
     * @return int|null
     */
    public function getOrderTypeId(): ?int;

    /**
     * Set Order Type ID
     *
     * @param int|null $orderTypeId
     * @return OrderTypeInterface
     */
    public function setOrderTypeId(int $orderTypeId = null): OrderTypeInterface;
}
