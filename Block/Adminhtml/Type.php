<?php

declare(strict_types=1);

namespace DanielPietka\OrderType\Block\Adminhtml;

use Magento\Backend\Block\Widget\Container;

class Type extends Container
{
    /**
     * Block constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();

        if (!$this->_isAllowedAction('DanielPietka_OrderType::save')) {
            $this->buttonList->remove('add');
        }
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction(string $resourceId): bool
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
