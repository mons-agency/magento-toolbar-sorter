<?php
/**
 * Copyright Mons Agency Ltd. Some rights reserved.
 * See copying.md for details.
 */

namespace Mons\ToolbarSorter\Plugin\Block\Adminhtml\Product\Attribute\Edit\Tab;

use Magento\Catalog\Block\Adminhtml\Product\Attribute\Edit\Tab\Front as Subject;
use Magento\Framework\Data\Form;
use Mons\ToolbarSorter\Model\Attribute\Source\SorterOptions;

class FrontPlugin
{
    /**
     * @param SorterOptions $options
     */
    public function __construct(
        private SorterOptions $options
    ) {}

    /**
     * Add toolbar sorter behavior field
     *
     * @param Subject $subject
     * @param Form $form
     * @return array
     */
    public function beforeSetForm(Subject $subject, Form $form)
    {
        /** @var \Magento\Framework\Data\Form\Element\Fieldset $fieldset */
        $fieldset = $form->getElement('front_fieldset');

        if ($fieldset) {
            $fieldset->addField(
                'sort_by_behavior',
                'select',
                [
                    'name' => 'sort_by_behavior',
                    'label' => __('Product Listing Sorter'),
                    // 'title' => __('Can be used only with catalog input type Yes/No, Dropdown, Multiple Select and Price'),
                    'note' => __('Depends on design theme.'),
                    'values' => $this->options->toOptionArray(),
                    'sortOrder' => 125,
                ],
                'used_for_sort_by'
            );

            // define field dependencies
            $subject->getChildBlock('form_after')
                ->addFieldMap('used_for_sort_by', 'used_for_sort_by')
                ->addFieldMap('sort_by_behavior', 'sort_by_behavior')
                ->addFieldDependence('sort_by_behavior', 'used_for_sort_by', '1');
        }

        return [$form];
    }
}
