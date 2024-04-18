<?php

declare(strict_types=1);

namespace DanielPietka\OrderType\Ui\Component\Type;

use DanielPietka\OrderType\Ui\Component\AddFilterInterface;
use Magento\Framework\Api\Filter;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;

class FulltextFilter implements AddFilterInterface
{
    /**
     * Class constructor
     *
     * @param FilterBuilder $filterBuilder
     */
    public function __construct(private readonly FilterBuilder $filterBuilder)
    {
    }

    /**
     * Adds custom filter to search criteria builder based on received filter.
     *
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param Filter $filter
     * @return void
     */
    public function addFilter(SearchCriteriaBuilder $searchCriteriaBuilder, Filter $filter): void
    {
        $titleFilter = $this->filterBuilder->setField('name')
            ->setValue(sprintf('%%%s%%', $filter->getValue()))
            ->setConditionType('like')
            ->create();

        $searchCriteriaBuilder->addFilter($titleFilter);
    }
}
