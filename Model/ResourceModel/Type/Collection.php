<?php

declare(strict_types=1);

namespace DanielPietka\OrderType\Model\ResourceModel\Type;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use DanielPietka\OrderType\Model\ResourceModel\Type as ResourceModel;
use DanielPietka\OrderType\Model\Type as TypeModel;

class Collection extends AbstractCollection
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(TypeModel::class, ResourceModel::class);
    }
}
