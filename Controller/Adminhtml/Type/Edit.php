<?php

declare(strict_types=1);

namespace DanielPietka\OrderType\Controller\Adminhtml\Type;

use DanielPietka\OrderType\Model\TypeFactory;
use DanielPietka\OrderType\Model\TypeRepository;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;

class Edit extends Action implements HttpGetActionInterface
{
    public const ADMIN_RESOURCE = 'DanielPietka_OrderType::edit';

    /**
     * Class constructor
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param TypeRepository $typeRepository
     * @param TypeFactory $typeFactory
     */
    public function __construct(
        Context $context,
        protected readonly PageFactory $resultPageFactory,
        protected readonly TypeRepository $typeRepository,
        protected readonly TypeFactory $typeFactory,
    ) {
        parent::__construct($context);
    }

    /**
     * Edit Action
     *
     * @return Redirect|Page
     */
    public function execute(): Redirect|Page
    {
        $type = $this->typeFactory->create();
        $typeId = (int)$this->getRequest()->getParam('type_id');

        if (!empty($typeId)) {
            /** @var Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();

            try {
                $type = $this->typeRepository->getById($typeId);

                if (!$type->getId()) {
                    $this->messageManager->addErrorMessage(
                        __('This type no longer exists.')
                    );

                    return $resultRedirect->setPath('*/*/');
                }

            } catch (NoSuchEntityException|LocalizedException $e) {
                $this->messageManager->addErrorMessage(
                    __('This type no longer exists.')
                );

                return $resultRedirect->setPath('*/*/');
            }
        }

        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(
            $type->getId()
            ? __('Edit Order Type: %1', $type->getName())
            : __('New Order Type')
        );

        return $resultPage;
    }
}
