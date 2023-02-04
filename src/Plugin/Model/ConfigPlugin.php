<?php
/**
 * Copyright Mons Agency Ltd. Some rights reserved.
 * See copying.md for details.
 */

namespace Mons\ToolbarSorter\Plugin\Model;

use Magento\Catalog\Model\Config as Subject;
use Mons\ToolbarSorter\Model\Config;

class ConfigPlugin
{
    /**
     * @param Config $config
     */
    public function __construct(
        private Config $config
    ) {}

    /**
     * Adding custom options and changing labels
     *
     * @param Subject $subject
     * @param [] $_options
     * @return []
     */
    public function afterGetAttributeUsedForSortByArray(Subject $subject, $_options)
    {
        $options = [];

        // better label
        $options[Config::POSITION_CODE] = $this->config->getPositionLabel();

        foreach ($subject->getAttributesUsedForSortBy() as $attribute) {
            $code = (string)$attribute->getAttributeCode();
            $label = (string)$attribute->getStoreLabel();
            $behavior = (string)$attribute->getSortByBehavior();

            // remove sorting options
            unset($options[$code]);

            // new sorting options
            switch ($behavior) {
                case Config::ASC:
                    $options[$code . '_' . Config::ASC] = $label;
                    break;

                case Config::DESC:
                    $options[$code . '_' . Config::DESC] = $label;
                    break;

                case Config::ASC_DESC:
                    $options[$code . '_' . Config::ASC] = $this->config->getAscDescDirectionLabel($label);
                    $options[$code . '_' . Config::DESC] = $this->config->getDescAscDirectionLabel($label);
                    break;

                case Config::DESC_ASC:
                    $options[$code . '_' . Config::DESC] = $this->config->getDescAscDirectionLabel($label);
                    $options[$code . '_' . Config::ASC] = $this->config->getAscDescDirectionLabel($label);
                    break;

                default:
                    $options[$code] = $label;
                    break;
            }
        }

        return $options;
    }
}
