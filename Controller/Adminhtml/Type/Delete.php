<?php

declare(strict_types=1);

namespace DanielPietka\OrderType\Controller\Adminhtml\Type;

use DanielPietka\OrderType\Model\TypeRepository;
use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;

class Delete extends Action implements HttpPostActionInterface
{
    public const ADMIN_RESOURCE = 'DanielPietka_OrderType::delete';

    /**
     * Class constructor
     *
     * @param Context $context
     * @param TypeRepository $typeRepository
     */
    public function __construct(
        Context $context,
        private readonly TypeRepository $typeRepository
    ) {
        parent::__construct($context);
    }

    /**
     * Delete action
     *
     * @return Redirect
     */
    public function execute(): Redirect
    {
        $typeId = (int)$this->getRequest()->getParam('type_id');

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($typeId) {
            try {
                $type = $this->typeRepository->getById($typeId);
                $this->typeRepository->delete($type);
                $this->messageManager->addSuccessMessage(
                    __('The Type: %1 has been deleted.', $type->getName())
                );

                return $resultRedirect->setPath('*/*/');
            } catch (Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());

                return $resultRedirect->setPath('*/*/edit', ['type_id' => $typeId]);
            }
        }

        $this->messageManager->addErrorMessage(
            __('We can\'t find a type to delete.')
        );

        return $resultRedirect->setPath('*/*/');
    }
}
