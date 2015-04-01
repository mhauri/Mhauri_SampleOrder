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
 * @copyright Copyright 2014, Marcel Hauri (https://github.com/mhauri/Mhauri_SampleOrder/)
 *
 * @category Order
 * @package Mhauri_SampleOrder
 * @author Marcel Hauri <marcel@hauri.me>
 */

class Mhauri_SampleOrder_Model_Observer
{

    /**
     * If it is allowed to add the product as a sample, add it to the basket and set the price to zero
     *
     * @param Varien_Event_Observer $observer
     */
    public function salesQuoteAddItem(Varien_Event_Observer $observer)
    {
        $item    = $observer->getQuoteItem();

        if ($item->getParentItem()) {
            $item = $item->getParentItem();
        }

        $product = $item->getProduct();

        if (Mage::helper('sampleorder')->isSampleOrderAllowed($product) && Mage::helper('sampleorder')->isSampleOrderItem($item)) {

            $name = Mage::helper('sampleorder')->__('Sample: %s', $product->getName());
            $params = array(
                'id'    => $product->getId(),
                'name'  => $name,
                'price' => 0
            );

            $product->setName($name);

            // check if the sample is already in the basket
            $count = 0;
            $cart = Mage::getModel('checkout/cart')->getQuote();
            foreach ($cart->getAllItems() as $cartItem) {
                if ($cartItem->getCustomPrice()) {
                    $count++;
                }
            }

            if ($count > 0) {
                Mage::getSingleton('checkout/session')->addError(Mage::helper('sampleorder')->__('The product %s cannot be ordered in the requested quantity.', $product->getName()));
                Mage::app()->getResponse()->setRedirect(Mage::getUrl('checkout/cart'))->sendResponse();
                exit;
            }

            $item->setName(Mage::helper('sampleorder')->__('Sample: %s', $item->getName()));
            $item->setCustomPrice(0);
            $item->setOriginalCustomPrice(0);
            $product->setIsSuperMode(true);
            $product->addCustomOption(Mhauri_SampleOrder_Helper_Data::SAMPLE_ORDER, serialize($params));
            $item->addOption($product->getCustomOption(Mhauri_SampleOrder_Helper_Data::SAMPLE_ORDER));
        }
    }

    /**
     * Be sure that a sample can only be ordered once in the cart
     *
     * @param Varien_Event_Observer $observer
     */
    public function checkoutCartUpdateItemsAfter(Varien_Event_Observer $observer)
    {
        $items = $observer->getCart()->getQuote()->getAllItems();
        foreach ($items as $item) {
            if (Mage::helper('sampleorder')->isSampleOrderItem($item)) {
                if ($item->getQty() > 1) {
                    $item->setName(Mage::helper('sampleorder')->__('Sample: %s', $item->getName()));
                    Mage::getSingleton('checkout/session')->addError(Mage::helper('sampleorder')->__('The product %s cannot be ordered in the requested quantity.', $item->getName()));
                    Mage::app()->getResponse()->setRedirect(Mage::getUrl('checkout/cart'))->sendResponse();
                    exit;
                }
            }
        }
    }
}
