<?php

declare(strict_types=1);

namespace DanielPietka\OrderType\Model\ResourceModel;

use DanielPietka\OrderType\Api\Data\TypeInterface;
use Magento\Framework\EntityManager\EntityManager;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class Type extends AbstractDb
{
    /**
     * Class constructor
     *
     * @param Context $context
     * @param MetadataPool $metadataPool
     * @param EntityManager $entityManager
     * @param string|null $connectionName
     */
    public function __construct(
        Context $context,
        protected MetadataPool $metadataPool,
        protected EntityManager $entityManager,
        string $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(TypeInterface::MAIN_TABLE, TypeInterface::FIELD_TYPE_ID);
    }
}
