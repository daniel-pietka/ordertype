<?php

declare(strict_types=1);

namespace DanielPietka\OrderType\Model;

use DanielPietka\OrderType\Api\Data\TypeInterface;
use DanielPietka\OrderType\Api\TypeRepositoryInterface;
use DanielPietka\OrderType\Model\ResourceModel\Type as TypeResource;
use DanielPietka\OrderType\Model\ResourceModel\Type\CollectionFactory;
use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsFactory;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

class TypeRepository implements TypeRepositoryInterface
{
    /**
     * Class constructor
     *
     * @param TypeFactory $typeFactory
     * @param TypeResource $typeResource
     * @param CollectionFactory $collectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param SearchResultsFactory $searchResultsFactory
     * @param OrderRepositoryInterface $orderRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param CartRepositoryInterface $quoteRepository
     */
    public function __construct(
        protected readonly TypeFactory $typeFactory,
        protected readonly TypeResource $typeResource,
        protected readonly CollectionFactory $collectionFactory,
        protected readonly CollectionProcessorInterface $collectionProcessor,
        protected readonly SearchResultsFactory $searchResultsFactory,
        protected readonly OrderRepositoryInterface $orderRepository,
        protected readonly SearchCriteriaBuilder $searchCriteriaBuilder,
        protected readonly CartRepositoryInterface $quoteRepository
    ) {
    }

    /**
     * Save Type
     *
     * @param TypeInterface $type
     * @return Type
     * @throws CouldNotSaveException
     */
    public function save(TypeInterface $type): Type
    {
        try {
            $this->typeResource->save($type);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the order type: %1', $exception->getMessage())
            );
        }

        return $type;
    }

    /**
     * Get Type by id
     *
     * @param int|null $typeId
     * @return Type
     * @throws NoSuchEntityException
     */
    public function getById(?int $typeId): Type
    {
        $type = $this->typeFactory->create();
        $this->typeResource->load($type, $typeId);

        if (!$type->getId()) {
            throw new NoSuchEntityException(
                __('Order type with id "%1" does not exist.', $typeId)
            );
        }

        return $type;
    }

    /**
     * Get Type list
     *
     * @param SearchCriteriaInterface|null $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(?SearchCriteriaInterface $searchCriteria = null): SearchResultsInterface
    {
        $collection = $this->collectionFactory->create();
        $searchResults = $this->searchResultsFactory->create();

        if ($searchCriteria !== null) {
            $this->collectionProcessor->process($searchCriteria, $collection);
            $searchResults->setSearchCriteria($searchCriteria);
        }

        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * Delete Type
     *
     * @param TypeInterface $type
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(TypeInterface $type): bool
    {
        try {
            $this->typeResource->delete($type);

            $searchCriteria = $this->searchCriteriaBuilder
                ->addFilter('order_type_id', $type->getId())
                ->create();

            $orders = $this->orderRepository->getList($searchCriteria)->getItems();

            foreach ($orders as $order) {
                $order->setData('order_type_id', null);
                $this->orderRepository->save($order);
            }

            $quotes = $this->quoteRepository->getList($searchCriteria)->getItems();

            foreach ($quotes as $quote) {
                $quote->setData('order_type_id', null);
                $this->quoteRepository->save($quote);
            }
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the order type: %1', $exception->getMessage())
            );
        }

        return true;
    }

    /**
     * Delete Type by id
     *
     * @param int $typeId
     * @return bool
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $typeId): bool
    {
        $type = $this->getById($typeId);

        return $this->delete($type);
    }
}
