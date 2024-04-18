<?php

declare(strict_types=1);

namespace DanielPietka\OrderType\Model\Type\Source;

class IsActiveFilter extends IsActive
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
