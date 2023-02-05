<?php
/**
 * Copyright Mons Agency Ltd. Some rights reserved.
 * See copying.md for details.
 */

namespace Mons\ToolbarSorter\Model\Attribute\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Mons\ToolbarSorter\Model\Config;

class SorterOptions implements OptionSourceInterface
{
    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => '',
                'label' => __('Default (do not override)'),
            ],
            [
                'value' => Config::ASC,
                'label' => __('Ascending'),
            ],
            [
                'value' => Config::DESC,
                'label' => __('Descending'),
            ],
            [
                'value' => Config::ASC_DESC,
                'label' => __('Ascending + Descending'),
            ],
            [
                'value' => Config::DESC_ASC,
                'label' => __('Descending + Ascending'),
            ],
        ];
    }
}
