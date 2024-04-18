<?php

declare(strict_types=1);

namespace DanielPietka\OrderType\Model;

use DanielPietka\OrderType\Api\Data\OrderTypeInterface;
use DanielPietka\OrderType\Api\OrderTypeGuestRepositoryInterface;
use DanielPietka\OrderType\Api\OrderTypeRepositoryInterface;
use Magento\Quote\Model\QuoteIdMaskFactory;
use Magento\Quote\Model\ResourceModel\Quote\QuoteIdMask as QuoteIdMaskResourceModel;

class OrderTypeGuestRepository implements OrderTypeGuestRepositoryInterface
{
    /**
     * Class constructor
     *
     * @param QuoteIdMaskFactory $quoteIdMaskFactory
     * @param OrderTypeRepositoryInterface $orderTypeRepository
     * @param QuoteIdMaskResourceModel $quoteIdMaskResourceModel
     */
    public function __construct(
        protected readonly QuoteIdMaskFactory $quoteIdMaskFactory,
        protected readonly OrderTypeRepositoryInterface $orderTypeRepository,
        protected readonly QuoteIdMaskResourceModel $quoteIdMaskResourceModel
    ) {
    }

    /**
     * Save Order Type ID
     *
     * @param string $cartId
     * @param OrderTypeInterface $orderType
     * @return OrderTypeInterface
     */
    public function saveOrderType(string $cartId, OrderTypeInterface $orderType): OrderTypeInterface
    {
        $quoteIdMask = $this->quoteIdMaskFactory->create();
        $this->quoteIdMaskResourceModel->load($quoteIdMask, $cartId, 'masked_id');

        return $this->orderTypeRepository->saveOrderType(
            (int)$quoteIdMask->getData('quote_id'),
            $orderType
        );
    }
}
