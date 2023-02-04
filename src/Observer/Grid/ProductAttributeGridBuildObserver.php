<?php
/**
 * Copyright Mons Agency Ltd. Some rights reserved.
 * See copying.md for details.
 */

namespace Mons\ToolbarSorter\Observer\Grid;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Mons\ToolbarSorter\Model\Config;

class ProductAttributeGridBuildObserver implements ObserverInterface
{
    /**
     * {@inheritDoc}
     */
    public function execute(Observer $observer)
    {
        /** @var \Magento\Catalog\Block\Adminhtml\Product\Attribute\Grid $grid */
        $grid = $observer->getGrid();

        if ($grid) {
            $grid->addColumnAfter(
                'sort_by_behavior',
                [
                        'header' => __('Product Listing Sorter'),
                        'sortable' => true,
                        'index' => 'sort_by_behavior',
                        'type' => 'options',
                        'options' => [
                            Config::ASC => __('Ascending'),
                            Config::DESC => __('Descending'),
                            Config::ASC_DESC => __('Ascending + Descending'),
                            Config::DESC_ASC => __('Descending + Ascending'),
                        ],
                        'align' => 'center',
                ],
                'used_for_sort_by'
            );
        }
    }
}
