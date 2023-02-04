<?php
/**
 * Copyright Mons Agency Ltd. Some rights reserved.
 * See copying.md for details.
 */

namespace Mons\ToolbarSorter\Model;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\ConfigFactory;

class Config
{
    const ASC = 'asc';
    const DESC = 'desc';
    const ASC_DESC = 'asc_desc';
    const DESC_ASC = 'desc_asc';
    const POSITION_CODE = 'position';

    /** @var array */
    private $usedForSortBy;

    /**
     * @param ConfigFactory $configFactory
     */
    public function __construct(
        protected ConfigFactory $configFactory
    ) {}

    /**
     * Return the sort by position label
     *
     * @return string
     */
    public function getPositionLabel(): string
    {
        // a simple plugin can override this
        return __('Relevance');
    }

    /**
     * Return the ASC + DESC direction label
     *
     * @param string $attributeLabel
     * @return string
     */
    public function getAscDescDirectionLabel(string $attributeLabel): string
    {
        // a simple plugin can override this
        return sprintf(__('%s (Low to High)'), $attributeLabel);
    }

    /**
     * Return the DESC + ASC direction label
     *
     * @param string $attributeLabel
     * @return string
     */
    public function getDescAscDirectionLabel(string $attributeLabel): string
    {
        // a simple plugin can override this
        return sprintf(__('%s (High to Low)'), $attributeLabel);
    }

    /**
     * Retrieve attributes array used for sort by
     *
     * @see Magento\Catalog\Model\Config::getAttributesUsedForSortBy()
     *
     * @return array
     */
    public function getAttributesUsedForSortBy(): array
    {
        if ($this->usedForSortBy === null) {
            $this->usedForSortBy = [];

            $entityType = Product::ENTITY;
            $attributesData = $this->configFactory->create()->getAttributesUsedForSortBy();

            foreach ($attributesData as $attributeData) {
                $attributeCode = $attributeData['attribute_code'];

                $this->usedForSortBy[$attributeCode] = $attributeData;
            }
        }

        return $this->usedForSortBy;
    }

    /**
     * Check if the attribute is used for sort by
     *
     * @return bool
     */
    public function isAttributeUsedForSortBy(string $attributeCode): bool
    {
        $attributes = $this->getAttributesUsedForSortBy();

        if ($attributeCode && isset($attributes[$attributeCode])) {
            return true;
        }

        return false;
    }

    /**
     * Return the expected behavior of the attribute
     *
     * @param string $attributeCode
     * @return string
     */
    public function getAttributeSortByBehavior(string $attributeCode): string
    {
        $attributes = $this->getAttributesUsedForSortBy();

        // failover
        if (!$attributeCode || !isset($attributes[$attributeCode])) {
            return '';
        }

        return $attributes[$attributeCode]['sort_by_behavior'] ?? '';
    }
}
