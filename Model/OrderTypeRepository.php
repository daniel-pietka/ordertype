<?php

declare(strict_types=1);

namespace DanielPietka\OrderType\Model;

use DanielPietka\OrderType\Api\Data\OrderTypeInterface;
use DanielPietka\OrderType\Api\OrderTypeRepositoryInterface;
use Exception;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Sales\Model\Order;

class OrderTypeRepository implements OrderTypeRepositoryInterface
{
    /**
     * Class constructor
     *
     * @param CartRepositoryInterface $cartRepository
     * @param OrderTypeInterface $orderType
     */
    public function __construct(
        protected readonly CartRepositoryInterface $cartRepository,
        protected readonly OrderTypeInterface $orderType
    ) {
    }

    /**
     * Save Order Type ID
     *
     * @param int $cartId
     * @param OrderTypeInterface $orderType
     * @return OrderTypeInterface
     * @throws NoSuchEntityException
     * @throws CouldNotSaveException
     */
    public function saveOrderType(int $cartId, OrderTypeInterface $orderType): OrderTypeInterface
    {
        $cart = $this->cartRepository->getActive($cartId);

        if (!$cart->getItemsCount()) {
            throw new NoSuchEntityException(__('Cart %1 is empty', $cartId));
        }

        try {
            $cart->setData(OrderTypeInterface::TYPE_ID, $orderType->getOrderTypeId());
            $this->cartRepository->save($cart);
        } catch (Exception $e) {
            throw new CouldNotSaveException(
                __('Could not save the order type! %1', $e->getMessage()),
            );
        }

        return $orderType;
    }

    /**
     * Get Order Type ID by Order
     *
     * @param Order $order
     * @return OrderTypeInterface
     * @throws NoSuchEntityException
     */
    public function getOrderType(Order $order) : OrderTypeInterface
    {
        if (!$order->getId()) {
            throw new NoSuchEntityException(__('Order %1 does not exist', $order));
        }

        $this->orderType->setOrderTypeId(
            $order->getData(OrderTypeInterface::TYPE_ID)
        );

        return $this->orderType;
    }
}
