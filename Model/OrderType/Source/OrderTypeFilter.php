<?php

declare(strict_types=1);

namespace DanielPietka\OrderType\Model\OrderType\Source;

class OrderTypeFilter extends OrderType
{
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return array_merge(
            [
                [
                    'label' => '',
                    'value' => ''
                ]
            ],
            parent::toOptionArray()
        );
    }
}
