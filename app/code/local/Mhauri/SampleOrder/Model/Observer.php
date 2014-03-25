<?php

/**
 * Class Mhauri_SampleOrder_Model_Observer
 */
class Mhauri_SampleOrder_Model_Observer
{
    /**
     * Set the options with origin product info
     *
     * @param Varien_Event_Observer $observer
     *
     * @event sales_quote_add_item
     */
    public function setQuoteOptions($observer)
    {
        $quoteItem = $observer->getEvent()->getQuoteItem();
        // is it a sample order
        if (Mage::helper('sampleorder')->isSampleOrder($quoteItem->getSku())) {
            if ($info = Mage::helper('sampleorder')->getOptions($quoteItem)) {
                $request = $info;
            } else {
                $request = Mage::app()->getRequest()->getParams();
            }

            // check if sku and id are set, if not it's maybe an reorder action, so catch them too
            if (!$request['sku'] || !$request['id']) {
                $request = Mage::app()->getRequest()->getParams();
                if(isset($request['order_id'])) {
                    // it's an reorder so get the data
                    $order = Mage::getModel('sales/order')->load($request['order_id']);
                    // now match current quoteItem with the item from the order
                    $items = $order->getAllItems();
                    foreach($items as $item) {
                        if(Mage::helper('sampleorder')->isSampleOrder($item->getSku())) {
                            if($quoteItem->getProductId() === $item->getProductId()) {
                                $request = Mage::helper('sampleorder')->getOptions($item);
                            }
                        }
                    }
                } elseif(!$request['sku'] || !$request['id']) {
                    // it's no reorder, so the params are missing, fail here
                    Mage::getSingleton('checkout/session')->addError(Mage::helper('sampleorder')->__('Please fill out all the required fields.'));
                    Mage::app()->getResponse()->setRedirect(Mage::getUrl('checkout/cart'))->sendResponse();
                    exit;
                }
            }

            // check if there is already a sample like this in the basket
            $count = 0;
            $cart = Mage::getModel('checkout/cart')->getQuote();
            foreach ($cart->getAllItems() as $item) {
                if(Mage::helper('sampleorder')->isSampleOrder($item->getSku())) {
                    $options = Mage::helper('sampleorder')->getOptions($item);
                    if($request['sku'] === $options['sku']) {
                        $count++;
                    }
                }
            }

            if($count > 1) {
                Mage::getSingleton('checkout/session')->addError(Mage::helper('Catalog')->__('Some of the products cannot be ordered in the requested quantity.'));
                Mage::app()->getResponse()->setRedirect(Mage::getUrl('checkout/cart'))->sendResponse();
                exit;
            }

            $sampleorder = array(
                'id'  => $request['id'],
                'sku' => $request['sku']
            );

            // store in quote item
            $product = $quoteItem->getProduct();
            $product->addCustomOption('sampleorder', serialize($sampleorder));
            $quoteItem->addOption($product->getCustomOption('sampleorder'));
        }
    }

    /**
     * Copy quote item options to order item
     *
     * @param Varien_Event_Observer $observer
     *
     * @event sales_convert_quote_item_to_order_item
     */
    public function rewriteCustomOptions($observer)
    {
        $item = $observer->getEvent()->getOrderItem();
        $quoteItem = $observer->getEvent()->getItem();

        if (Mage::helper('sampleorder')->isSampleOrder($item->getSku())
            && $sampleorder = Mage::helper('sampleorder')->getOptions($quoteItem)
        ) {
            $options['sampleorder'] = $sampleorder;
            $item->setProductOptions($options);
        }
    }
}
