<?php

/**
 * Class Mhauri_SampleOrder_Model_Observer
 */
class Mhauri_SampleOrder_Model_Observer
{
    public function checkoutCartProductAddAfter(Varien_Event_Observer $observer)
    {
        $item    = $observer->getQuoteItem();

        if ($item->getParentItem()) {
            $item = $item->getParentItem();
        }

        $product = $item->getProduct();

        if(Mage::helper('sampleorder')->isSampleOrderAllowed($product) && $item->getBuyRequest()->getSampleorder()) {

            $name = Mage::helper('sampleorder')->__('Sample: %s', $product->getName());

            $params = array(
                'id'    => $product->getId(),
                'name'  => $name,
                'price' => 0
            );

            // check if the sample is already in the basket
            $count = 0;
            $cart = Mage::getModel('checkout/cart')->getQuote();
            foreach ($cart->getAllItems() as $cartItem) {
                if($cartItem->getCustomPrice()) {
                    $sampleorder = $cartItem->getBuyRequest()->getSampleorder();
                    if(intval($sampleorder['product_id']) === intval($product->getId())) {
                        $count++;
                    }
                }
            }

            if($count > 0) {
                Mage::getSingleton('checkout/session')->addError(Mage::helper('Catalog')->__('Some of the products cannot be ordered in the requested quantity.'));
                Mage::app()->getResponse()->setRedirect(Mage::getUrl('checkout/cart'))->sendResponse();
                exit;
            }

            $item->setCustomPrice(0);
            $item->setOriginalCustomPrice(0);
            $item->setCustomName($name);
            $item->setOriginalCustomName($name);
            $product->setIsSuperMode(true);
            $product->addCustomOption(Mhauri_SampleOrder_Helper_Data::SAMPLE_ORDER, serialize($params));
            $item->addOption($product->getCustomOption(Mhauri_SampleOrder_Helper_Data::SAMPLE_ORDER));
        }
    }


    public function checkoutCartUpdateItemsAfter(Varien_Event_Observer $observer)
    {
        $items = $observer->getCart()->getQuote()->getAllVisibleItems();
        foreach($items as $item) {
            $test = $item;
        }
    }
}
