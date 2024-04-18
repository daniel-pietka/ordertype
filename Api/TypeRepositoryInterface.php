<?php

namespace DanielPietka\OrderType\Api;

use DanielPietka\OrderType\Api\Data\TypeInterface;
use DanielPietka\OrderType\Model\Type;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;

interface TypeRepositoryInterface
{
    /**
     * Save Type
     *
     * @param TypeInterface $type
     * @return Type
     */
    public function save(TypeInterface $type): Type;

    /**
     * Get Type by ID
     *
     * @param int $typeId
     * @return Type
     */
    public function getById(int $typeId): Type;

    /**
     * Get Type List
     *
     * @param SearchCriteriaInterface|null $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(?SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * Delete Type
     *
     * @param TypeInterface $type
     * @return bool
     */
    public function delete(TypeInterface $type): bool;

    /**
     * Delete Type by ID
     *
     * @param int $typeId
     * @return bool
     */
    public function deleteById(int $typeId): bool;
}
