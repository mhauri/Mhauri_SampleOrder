<?php
class Mhauri_SampleOrder_AddController extends Mage_Core_Controller_Front_Action
{
    /**
     * check if it is an existing product and if it can be ordered as sample
     */
    public function productAction()
    {

        $session = Mage::getSingleton('customer/session');

        $productId = (int) $this->getRequest()->getParam('id');
        if (!$productId) {
            $this->_redirect('/');
            return;
        }

        $product = Mage::getModel('catalog/product')->load($productId);
        if (!$product->getId() || !$product->isVisibleInCatalog()) {
            $session->addError(Mage::helper('sampleorder')->__('Not a valid product!'));
            $this->_redirect('/');
            return;
        }

        if(Mage::helper('sampleorder')->isSampleOrderAllowed($product)) {

            $option[Mhauri_SampleOrder_Helper_Data::SAMPLE_ORDER] = array(
                'product_id' => $productId,
                'timestamp'  => time()
            );
            $cart = Mage::getSingleton('checkout/cart');
            $cart->addProduct($productId, $option);
            $cart->save();

            Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
            $message = Mage::helper('sampleorder')->__('%s was successfully added to your shopping cart.', $product->getName());
            Mage::getSingleton('checkout/session')->addSuccess($message);
            Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl('checkout/cart'));
        } else {
            $session->addError(Mage::helper('sampleorder')->__(''));
            $this->_redirect('/');
            return;
        }
    }
}
