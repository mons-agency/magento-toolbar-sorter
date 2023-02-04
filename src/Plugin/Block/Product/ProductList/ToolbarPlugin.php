<?php
/**
 * Copyright Mons Agency Ltd. Some rights reserved.
 * See copying.md for details.
 */

namespace Mons\ToolbarSorter\Plugin\Block\Product\ProductList;

use Magento\Catalog\Block\Product\ProductList\Toolbar;
use Magento\Framework\Data\Collection;
use Mons\ToolbarSorter\Model\Config;

class ToolbarPlugin
{
    /** @var string */
    private $currentOrder;
    /** @var string */
    private $currentDirection;
    /** @var array */
    private $usedForSortBy;

    /**
     * @param Config $config
     */
    public function __construct(
        private Config $config
    ) {}

    /**
     * Plugin
     *
     * @param Toolbar $subject
     * @param Collection $collection
     * @return array
     */
    public function beforeSetCollection(Toolbar $subject, $collection)
    {
        $this->currentOrder = $subject->getCurrentOrder();
        $this->currentDirection = $subject->getCurrentDirection();

        // real attribute, skip custom logic
        if (
            $this->currentOrder == Config::POSITION_CODE ||
            $this->config->isAttributeUsedForSortBy($this->currentOrder)
        ) {
            return [$collection];
        }

        // attribute code and direction override
        if (str_ends_with($this->currentOrder, '_' . Config::DESC)) {
            $attributeCode = substr($this->currentOrder, 0, -5);

            if ($this->config->isAttributeUsedForSortBy($attributeCode)) {
                $subject->setData('_current_grid_order', $attributeCode);
                $subject->setData('_current_grid_direction', Config::DESC);
            }
        } else if (str_ends_with($this->currentOrder, '_' . Config::ASC)) {
            $attributeCode = substr($this->currentOrder, 0, -4);

            if ($this->config->isAttributeUsedForSortBy($attributeCode)) {
                $subject->setData('_current_grid_order', $attributeCode);
                $subject->setData('_current_grid_direction', Config::ASC);
            }
        }

        return [$collection];
    }

    /**
     * Plugin
     *
     * @param Toolbar $subject
     * @return Toolbar
     */
    public function afterSetCollection(Toolbar $subject)
    {
        // restore the original values
        $subject->setData('_current_grid_order', $this->currentOrder);
        $subject->setData('_current_griddirection', $this->currentDirection);

        return $subject;
    }
}
