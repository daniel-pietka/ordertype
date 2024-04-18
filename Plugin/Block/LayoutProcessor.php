<?php

declare(strict_types=1);

namespace DanielPietka\OrderType\Plugin\Block;

use DanielPietka\OrderType\Model\ResourceModel\Type\CollectionFactory as TypeCollectionFactory;
use Magento\Checkout\Block\Checkout\LayoutProcessor as BaseLayoutProcessor;
use DanielPietka\OrderType\Model\OrderType\Source\OrderType as OrderTypeSource;

class LayoutProcessor
{
    /**
     * Class constructor
     *
     * @param TypeCollectionFactory $typeCollectionFactory
     * @param OrderTypeSource $orderTypeSource
     */
    public function __construct(
        protected TypeCollectionFactory $typeCollectionFactory,
        protected OrderTypeSource $orderTypeSource,
    ) {
    }

    /**
     * After Process plugin
     *
     * @param BaseLayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(BaseLayoutProcessor $subject, array $jsLayout): array
    {
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['before-form']['children'] = $this->getOrderTypeForm();

        return $jsLayout;
    }

    /**
     * Get Order Type Form
     *
     * @return array
     */
    private function getOrderTypeForm(): array
    {
        return [
            'order-type-checkout-form-container' => [
                'component' => 'DanielPietka_OrderType/js/view/order-type-checkout-form',
                'provider' => 'checkoutProvider',
                'config' => [
                    'template' => 'DanielPietka_OrderType/order-type-checkout-form'
                ],
                'children' => [
                    'custom-checkout-form-fieldset' => [
                        'component' => 'uiComponent',
                        'displayArea' => 'order-type-checkout-form-fields',
                        'children' => [
                            'order_type_id' => [
                                'component' => 'Magento_Ui/js/form/element/abstract',
                                'config' => [
                                    'customScope' => 'orderTypeCheckoutForm',
                                    'template' => 'ui/form/field',
                                    'elementTmpl' => 'DanielPietka_OrderType/form/element/order-type-radio',
                                ],
                                'options' => $this->orderTypeSource->toOptionArray(),
                                'value' => 1,
                                'provider' => 'checkoutProvider',
                                'dataScope' => 'orderTypeCheckoutForm.order_type_id',
                                'label' => __('Select Order Type'),
                                'sortOrder' => 1,
                                'validation' => [
                                    'required-entry' => true
                                ],
                                'visible' => true,
                                'id' => 'order-type'
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }
}
