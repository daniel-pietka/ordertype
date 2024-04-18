<?php

declare(strict_types=1);

namespace DanielPietka\OrderType\Ui\Component\Listing\Column\OrderType;

use DanielPietka\OrderType\Model\OrderType\Source\OrderTypeFilter;
use Magento\Framework\Data\OptionSourceInterface;

class Options implements OptionSourceInterface
{
    /**
     * Class constructor
     *
     * @param OrderTypeFilter $orderTypeFilter
     */
    public function __construct(protected OrderTypeFilter $orderTypeFilter)
    {
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return $this->orderTypeFilter->toOptionArray();
    }
}
