<?php

declare(strict_types=1);

namespace DanielPietka\OrderType\Block\Adminhtml\Type\Edit;

use DanielPietka\OrderType\Api\TypeRepositoryInterface;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;

class GenericButton
{
    /**
     * Class constructor
     *
     * @param Context $context
     * @param TypeRepositoryInterface $typeRepository
     */
    public function __construct(
        protected Context $context,
        protected TypeRepositoryInterface $typeRepository
    ) {
    }

    /**
     * Return Order Type ID
     *
     * @return int|null
     */
    public function getTypeId(): ?int
    {
        try {
            $typeId = (int)$this->context->getRequest()->getParam('type_id');

            return $this->typeRepository->getById($typeId)->getId();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    /**
     * Generate url by route and parameters
     *
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl(string $route = '', array $params = []): string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
