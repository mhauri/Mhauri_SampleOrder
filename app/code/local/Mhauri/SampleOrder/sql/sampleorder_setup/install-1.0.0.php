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

$this->startSetup();

$this->addAttribute('catalog_product', Mhauri_SampleOrder_Helper_Data::SAMPLE_ORDER, array(
    'group'             => 'General',
    'type'              => 'int',
    'label'             => 'Sample order allowed',
    'input'             => 'select',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible'           => false,
    'required'          => true,
    'user_defined'      => true,
    'default'           => 0,
    'searchable'        => false,
    'filterable'        => true,
    'comparable'        => false,
    'visible_on_front'  => false,
    'unique'            => false,
    'apply_to'          => Mage_Catalog_Model_Product_Type::TYPE_SIMPLE,
    'is_configurable'   => true,
    'option' =>
        array (
            'values' =>
                array (
                    0 => 'No',
                    1 => 'Yes',
                )
        )
));
$this->endSetup();
