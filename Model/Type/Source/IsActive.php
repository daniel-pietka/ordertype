<?php

declare(strict_types=1);

namespace DanielPietka\OrderType\Model\Type\Source;

use DanielPietka\OrderType\Api\Data\TypeInterface;
use Magento\Framework\Data\OptionSourceInterface;

class IsActive implements OptionSourceInterface
{
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            [
                'value' => TypeInterface::STATUS_ENABLED,
                'label' => __('Enabled')
            ],
            [
                'value' => TypeInterface::STATUS_DISABLED,
                'label' => __('Disabled')
            ]
        ];
    }
}
