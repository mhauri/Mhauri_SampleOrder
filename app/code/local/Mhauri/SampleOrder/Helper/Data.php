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

    /**
     * Retrieve url for adding product as sample
     *
     * @param Mage_Catalog_Model_Product $item
     *
     * @return  string|bool
     */
    public function getAddUrl($item)
    {
        $productId = null;
        if ($item instanceof Mage_Catalog_Model_Product) {
            $productId = $item->getEntityId();
        }

        if ($productId) {
            return $this->_getUrl('sampleorder/add/product/id/' . $productId);
        }

        return false;
    }
}
