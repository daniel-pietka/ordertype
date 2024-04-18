<?php

declare(strict_types=1);

namespace DanielPietka\OrderType\Model\OrderType\Source;

use DanielPietka\OrderType\Model\ResourceModel\Type\CollectionFactory as TypeCollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;

class OrderType implements OptionSourceInterface
{
    /**
     * Class constructor
     *
     * @param TypeCollectionFactory $typeCollectionFactory
     */
    public function __construct(
        protected TypeCollectionFactory $typeCollectionFactory
    ) {
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        $collection = $this->typeCollectionFactory->create();
        $options = [];

        foreach ($collection as $type) {
            $options[] = [
                'value' => $type->getId(),
                'label' => $type->getName()
            ];
        }

        return $options;
    }
}
