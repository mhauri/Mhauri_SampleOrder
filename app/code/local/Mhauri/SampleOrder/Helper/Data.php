<?php

/**
 * Class Mhauri_SampleOrder_Helper_Data
 */
class Mhauri_SampleOrder_Helper_Data extends Mage_Core_Helper_Abstract
{

    const SAMPLE_ORDER = 'sampleorder';

    /**
     * Check if the product allows sample orders
     *
     * @param Mage_Catalog_Model_Product $item
     * @return bool
     */
    public function isSampleOrderAllowed(Mage_Catalog_Model_Product $item)
    {
        if(strtolower($item->getAttributeText(self::SAMPLE_ORDER)) === 'yes')
        {
            return true;
        }
        return false;
    }
}
