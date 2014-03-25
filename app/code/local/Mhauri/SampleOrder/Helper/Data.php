<?php

/**
 * Class Mhauri_SampleOrder_Helper_Data
 */
class Mhauri_SampleOrder_Helper_Data extends Mage_Core_Helper_Abstract
{

    const SKU_SAMPLE_ORDER = 'sampleorder';


    /**
     * Returns true if the product
     * of the given SKU is a sampleorder
     *
     * @param string $sku
     * @return bool
     */
    public function isSampleOrder($sku)
    {
        return strpos($sku, self::SKU_SAMPLE_ORDER) === 0;
    }

    /**
     * Returns the request sample options, as there are many ways we try to catch them all
     *
     * @param Mage_Sales_Model_Quote_Item $item
     * @return mixed
     */
    public function getOptions($item)
    {
        if($options = $item->getOptionByCode(self::SKU_SAMPLE_ORDER)) {
            return unserialize($options->getValue());
        } else if($options = $item->getOptionByCode('info_buyRequest')) {
            return unserialize($options->getValue());
        } else if ($options = $item->getProductOptions()) {
            if(isset($options['info_buyRequest'])) {
                return $options['info_buyRequest'];
            } else {
                return $options[self::SKU_SAMPLE_ORDER];
            }

        }
        return false;
    }
}