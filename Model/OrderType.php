<?php

declare(strict_types=1);

namespace DanielPietka\OrderType\Model;

use DanielPietka\OrderType\Api\Data\OrderTypeInterface;
use Magento\Framework\Api\AbstractSimpleObject;

class OrderType extends AbstractSimpleObject implements OrderTypeInterface
{
    /**
     * Get Order Type ID
     *
     * @return int|null
     */
    public function getOrderTypeId(): ?int
    {
        return $this->_get(self::TYPE_ID) !== null
            ? (int)$this->_get(self::TYPE_ID)
            : null;
    }

    /**
     * Set Order Type ID
     *
     * @param int|null $orderTypeId
     * @return OrderTypeInterface
     */
    public function setOrderTypeId(int $orderTypeId = null): OrderTypeInterface
    {
        return $this->setData(self::TYPE_ID, $orderTypeId);
    }
}
