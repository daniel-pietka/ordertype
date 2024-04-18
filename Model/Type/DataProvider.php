<?php

declare(strict_types=1);

namespace DanielPietka\OrderType\Model\Type;

use DanielPietka\OrderType\Api\Data\TypeInterface;
use DanielPietka\OrderType\Api\TypeRepositoryInterface;
use DanielPietka\OrderType\Model\ResourceModel\Type\CollectionFactory;
use DanielPietka\OrderType\Model\TypeFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Ui\DataProvider\ModifierPoolDataProvider;

class DataProvider extends ModifierPoolDataProvider
{
    /**
     * Class constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $pageCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param RequestInterface $request
     * @param TypeRepositoryInterface $typeRepository
     * @param TypeFactory $typeFactory
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     * @param array|null $loadedData
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        CollectionFactory $pageCollectionFactory,
        protected DataPersistorInterface $dataPersistor,
        private readonly RequestInterface $request,
        private readonly TypeRepositoryInterface $typeRepository,
        private readonly TypeFactory $typeFactory,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null,
        protected ?array $loadedData = null
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
        $this->collection = $pageCollectionFactory->create();
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData(): array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $type = $this->getCurrentType();
        $this->loadedData[$type->getId()] = $type->getData();

        return $this->loadedData;
    }

    /**
     * Return current type
     *
     * @return TypeInterface
     */
    private function getCurrentType(): TypeInterface
    {
        $typeId = $this->getTypeId();

        if ($typeId) {
            try {
                $type = $this->typeRepository->getById($typeId);
            } catch (LocalizedException $exception) {
                $type = $this->typeFactory->create();
            }

            return $type;
        }

        $data = $this->dataPersistor->get('order_type');

        if (empty($data)) {
            return $this->typeFactory->create();
        }

        $this->dataPersistor->clear('order_type');

        return $this->typeFactory->create()->setData($data);
    }

    /**
     * Returns current type id from request
     *
     * @return int
     */
    private function getTypeId(): int
    {
        return (int)$this->request->getParam($this->getRequestFieldName());
    }
}
