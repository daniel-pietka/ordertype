<?php

namespace DanielPietka\OrderType\Api\Data;

interface TypeInterface
{
    public const MAIN_TABLE = 'order_type';
    public const FIELD_TYPE_ID = 'type_id';
    public const FIELD_NAME = 'name';
    public const FIELD_IS_ACTIVE = 'is_active';

    public const STATUS_ENABLED = 1;
    public const STATUS_DISABLED = 0;

    /**
     * Get Type id
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Set Type ID
     *
     * @param mixed $value
     * @return TypeInterface
     */
    public function setId(mixed $value): TypeInterface;

    /**
     * Get Type Name
     *
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * Set Type Name
     *
     * @param string $name
     * @return TypeInterface
     */
    public function setName(string $name): TypeInterface;

    /**
     * Get Type Is Active
     *
     * @return bool
     */
    public function getIsActive(): bool;

    /**
     * Set Type Is Active
     *
     * @param bool $isActive
     * @return TypeInterface
     */
    public function setIsActive(bool $isActive): TypeInterface;
}
