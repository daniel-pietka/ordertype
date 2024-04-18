<?php

declare(strict_types=1);

namespace DanielPietka\OrderType\Block\Order;

use DanielPietka\OrderType\Api\Data\TypeInterface;
use DanielPietka\OrderType\Model\TypeRepository;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;

class OrderTypeInfo extends Template
{
    /**
     * Class constructor
     *
     * @param Context $context
     * @param TypeRepository $typeRepository
     * @param OrderRepositoryInterface $orderRepository
     * @param array $data
     */
    public function __construct(
        Context $context,
        protected TypeRepository $typeRepository,
        protected OrderRepositoryInterface $orderRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Get Order Type Label
     *
     * @return string|null
     */
    public function getOrderTypeLabel(): ?string
    {
        $order = $this->getOrder();

        if ($order !== null) {
            return $this->getTypeByOrder($order)?->getName();
        }

        return null;
    }

    /**
     * Get order from Request
     *
     * @return OrderInterface|null
     */
    protected function getOrder(): ?OrderInterface
    {
        $orderId = $this->_request->getParam('order_id', false);

        if ($orderId) {
            try {
                return $this->orderRepository->get((int)$orderId);
            } catch (LocalizedException $e) {
                return null;
            }
        }

        return null;
    }

    /**
     * Get Type by order
     *
     * @param OrderInterface $order
     * @return TypeInterface|null
     */
    protected function getTypeByOrder(OrderInterface $order): ?TypeInterface
    {
        $orderTypeId = $order->getData('order_type_id') ?: false;

        if ($orderTypeId) {
            try {
                return $this->typeRepository->getById((int)$orderTypeId);
            } catch (LocalizedException $e) {
                return null;
            }
        }

        return null;
    }
}
