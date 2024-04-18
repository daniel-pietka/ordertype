<?php

declare(strict_types=1);

namespace DanielPietka\OrderType\Ui\Component\Listing\Column;

use Magento\Cms\Block\Adminhtml\Page\Grid\Renderer\Action\UrlBuilder;
use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class TypeActions extends Column
{
    public const TYPE_URL_PATH_EDIT = 'order_type/type/edit';
    public const TYPE_URL_PATH_DELETE = 'order_type/type/delete';

    /**
     * Class constrictor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlBuilder $actionUrlBuilder
     * @param UrlInterface $urlBuilder
     * @param Escaper $escaper
     * @param array $components
     * @param array $data
     * @param string $editUrl
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        protected UrlBuilder $actionUrlBuilder,
        protected UrlInterface $urlBuilder,
        private readonly Escaper $escaper,
        array $components = [],
        array $data = [],
        private readonly string $editUrl = self::TYPE_URL_PATH_EDIT
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');

                if (isset($item['type_id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl($this->editUrl, ['type_id' => $item['type_id']]),
                        'label' => __('Edit'),
                    ];

                    $title = $this->escaper->escapeHtml($item['name']);

                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(
                            self::TYPE_URL_PATH_DELETE,
                            ['type_id' => $item['type_id']]
                        ),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete %1', $title),
                            'message' => __('Are you sure you want to delete a %1 record?', $title),
                        ],
                        'post' => true,
                    ];
                }
            }
        }

        return $dataSource;
    }
}
