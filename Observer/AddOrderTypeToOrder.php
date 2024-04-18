<?php

declare(strict_types=1);

namespace DanielPietka\OrderType\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use DanielPietka\OrderType\Api\Data\OrderTypeInterface;

class AddOrderTypeToOrder implements ObserverInterface
{
    /**
     * Execute observer method
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        $order = $observer->getEvent()->getOrder();
        $quote = $observer->getEvent()->getQuote();

        if ($order && $quote) {
            $order->setData(OrderTypeInterface::TYPE_ID, $quote->getData(OrderTypeInterface::TYPE_ID));
        }
    }
}
