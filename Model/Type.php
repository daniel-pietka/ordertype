<?php

declare(strict_types=1);

namespace DanielPietka\OrderType\Model;

use DanielPietka\OrderType\Api\Data\TypeInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;
use DanielPietka\OrderType\Model\ResourceModel\Type as TypeResourceModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Data\Collection\AbstractDb;

/**
 * Order Type Model
 *
 * @api
 * @method Type setStoreId(int $storeId)
 * @method int getStoreId()
 */
class Type extends AbstractModel implements TypeInterface
{
    /**
     * Construct init
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(TypeResourceModel::class);
    }

    /**
     * Prepare Order Type statuses
     *
     * @return array
     */
    public function getAvailableStatuses(): array
    {
        return [
            self::STATUS_ENABLED => __('Enabled'),
            self::STATUS_DISABLED => __('Disabled')
        ];
    }

    /**
     * Get Type ID
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->getData(TypeInterface::FIELD_TYPE_ID) !== null
            ? (int)$this->getData(TypeInterface::FIELD_TYPE_ID)
            : null;
    }

    /**
     * Set Type ID
     *
     * @param mixed $value
     * @return TypeInterface
     */
    public function setId(mixed $value): TypeInterface
    {
        return $this->setData(TypeInterface::FIELD_TYPE_ID, $value);
    }

    /**
     * Get Type Name
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->getData(TypeInterface::FIELD_NAME) !== null
            ? (string)$this->getData(TypeInterface::FIELD_NAME)
            : null;
    }

    /**
     * Set Type Name
     *
     * @param string $name
     * @return TypeInterface
     */
    public function setName(string $name): TypeInterface
    {
        return $this->setData(TypeInterface::FIELD_NAME, $name);
    }

    /**
     * Get Type Is Active
     *
     * @return bool
     */
    public function getIsActive(): bool
    {
        return $this->getData(TypeInterface::FIELD_IS_ACTIVE) !== null &&
            (bool)$this->getData(TypeInterface::FIELD_IS_ACTIVE);
    }

    /**
     * Set Type Is Active
     *
     * @param bool $isActive
     * @return TypeInterface
     */
    public function setIsActive(bool $isActive = true): TypeInterface
    {
        return $this->setData(TypeInterface::FIELD_IS_ACTIVE, $isActive);
    }
}
