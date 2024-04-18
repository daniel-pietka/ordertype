<?php

declare(strict_types=1);

namespace DanielPietka\OrderType\Controller\Adminhtml\Type;

use DanielPietka\OrderType\Api\Data\TypeInterface;
use DanielPietka\OrderType\Model\TypeFactory;
use DanielPietka\OrderType\Model\TypeRepository;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Throwable;

class Save extends Action implements HttpPostActionInterface
{
    public const ADMIN_RESOURCE = 'DanielPietka_OrderType::save';

    /**
     * Class constructor
     *
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param TypeFactory $typeFactory
     * @param TypeRepository $typeRepository
     */
    public function __construct(
        Context $context,
        protected readonly DataPersistorInterface $dataPersistor,
        private readonly TypeFactory $typeFactory,
        private readonly TypeRepository $typeRepository
    ) {
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return Redirect|ResultInterface
     */
    public function execute(): Redirect|ResultInterface
    {
        $data = $this->getRequest()->getParams();

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data) {
            if (empty($data['type_id'])) {
                $data['type_id'] = null;
            }

            if (isset($data['is_active']) && $data['is_active'] === '1') {
                $data['is_active'] = TypeInterface::STATUS_ENABLED;
            } else {
                $data['is_active'] = TypeInterface::STATUS_DISABLED;
            }

            /** @var TypeInterface $model */
            $model = $this->typeFactory->create();
            $typeId = (int)$this->getRequest()->getParam('type_id');

            if ($typeId) {
                try {
                    $model = $this->typeRepository->getById($typeId);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(
                        __('This page no longer exists.')
                    );

                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            try {
                $this->typeRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the Order Type.'));

                return $this->processResultRedirect($model, $resultRedirect, $data);
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?: $e);
            } catch (Throwable $e) {
                $this->messageManager->addErrorMessage(
                    __('Something went wrong while saving the Order Type.')
                );
            }

            $this->dataPersistor->set('order_type', $data);

            return $resultRedirect->setPath(
                '*/*/edit',
                [
                    'type_id' => $this->getRequest()->getParam('type_id')
                ]
            );
        }

        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Process result redirect
     *
     * @param TypeInterface $model
     * @param Redirect $resultRedirect
     * @param array $data
     * @return Redirect
     * @throws LocalizedException
     */
    private function processResultRedirect(TypeInterface $model, Redirect $resultRedirect, array $data): Redirect
    {
        if ($this->getRequest()->getParam('back', false) === 'duplicate') {
            $newType = $this->typeFactory->create(['data' => $data]);
            $newType->setId(null);
            $name = $model->getName() . '-' . uniqid('new-', true);
            $newType->setName($name);
            $newType->setIsActive(false);
            $this->typeRepository->save($newType);
            $this->messageManager->addSuccessMessage(__('You duplicated the Order Type.'));

            return $resultRedirect->setPath(
                '*/*/edit',
                [
                    'type_id' => $newType->getId(),
                    '_current' => true,
                ]
            );
        }

        $this->dataPersistor->clear('order_type');

        if ($this->getRequest()->getParam('back')) {
            return $resultRedirect->setPath('*/*/edit', ['type_id' => $model->getId(), '_current' => true]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
