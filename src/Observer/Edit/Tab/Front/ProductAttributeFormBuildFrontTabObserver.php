<?php
/**
 * Copyright Mons Agency Ltd. Some rights reserved.
 * See copying.md for details.
 */

namespace Mons\ToolbarSorter\Observer\Edit\Tab\Front;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Mons\ToolbarSorter\Model\Attribute\Source\SorterOptions;

class ProductAttributeFormBuildFrontTabObserver implements ObserverInterface
{
    /**
     * @param SorterOptions $options
     */
    public function __construct(
        private SorterOptions $options
    ) {}

    /**
     * {@inheritDoc}
     */
    public function execute(Observer $observer)
    {
        /** @var \Magento\Framework\Data\Form\AbstractForm $form */
        $form = $observer->getForm();
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
        }
    }
}
