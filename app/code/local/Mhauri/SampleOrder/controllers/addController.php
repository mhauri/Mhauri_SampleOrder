<?php
/**
 * Copyright (c) 2014, Marcel Hauri
 * All rights reserved.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @copyright Copyright 2014, Marcel Hauri (https://github.com/mhauri)
 *
 * @category Order
 * @package Mhauri_SampleOrder
 * @author Marcel Hauri <marcel@hauri.me>
 */

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
