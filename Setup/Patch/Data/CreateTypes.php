<?php

namespace DanielPietka\OrderType\Setup\Patch\Data;

use DanielPietka\OrderType\Model\TypeFactory;
use Exception;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;
use DanielPietka\OrderType\Model\TypeRepository;

class CreateTypes implements DataPatchInterface, PatchVersionInterface
{
    /**
     * Class constructor
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param TypeFactory $typeFactory
     * @param TypeRepository $typeRepository
     */
    public function __construct(
        private readonly ModuleDataSetupInterface $moduleDataSetup,
        private readonly TypeFactory $typeFactory,
        private readonly TypeRepository $typeRepository
    ) {
    }

    /**
     * Run code inside patch
     *
     * @return void
     * @throws CouldNotSaveException
     */
    public function apply(): void
    {
        $orderTypes = [
            [
                'type_id' => null,
                'name' => 'Standard Order',
                'is_active' => 1
            ],
            [
                'type_id' => null,
                'name' => 'Exhibition Order',
                'is_active' => 1
            ],
            [
                'type_id' => null,
                'name' => 'Test Order',
                'is_active' => 1
            ]
        ];

        $this->moduleDataSetup->getConnection()->startSetup();

        foreach ($orderTypes as $type) {
            $this->saveType($type);
        }

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * Get array of patches that have to be executed prior to this.
     *
     * @return string[]
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * This version associate patch with Magento setup version.
     *
     * @return string
     */
    public static function getVersion(): string
    {
        return '1.0.0';
    }

    /**
     * Get aliases (previous names) for the patch.
     *
     * @return string[]
     */
    public function getAliases(): array
    {
        return [];
    }

    /**
     * Save order Type
     *
     * @param array $data
     * @return void
     * @throws CouldNotSaveException
     * @throws Exception
     */
    private function saveType(array $data): void
    {
        $model = $this->typeFactory->create();
        $model->setData($data);
        $this->typeRepository->save($model);
    }
}
