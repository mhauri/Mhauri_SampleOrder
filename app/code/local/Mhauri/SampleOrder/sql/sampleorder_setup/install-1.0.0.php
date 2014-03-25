<?php

/* @var $this Mage_Core_Model_Resource_Setup */
$this->startSetup();

$product = new Mage_Catalog_Model_Product();
$product->setTypeId(Mage_Catalog_Model_Product_Type::TYPE_VIRTUAL)
    ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_CATALOG)
    ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
    ->setWebsiteIds(array(1))
    ->setStoreId(Mage_Core_Model_App::ADMIN_STORE_ID)
    ->setAttributeSetId(intval(Mage::getModel('catalog/product')->getResource()->getEntityType()->getDefaultAttributeSetId()))
    ->setSku(Mhauri_SampleOrder_Helper_Data::SKU_SAMPLE_ORDER)
    ->setName('Sample Order')
    ->setPrice(0.00)
    ->setTaxClassId(0)
    ->setCreatedAt(strtotime('now'))
    ->setStockData(
        array(
            'is_in_stock' => 1,
            'use_config_manage_stock' => 0,
            'manage_stock' => 0,
            'use_config_min_sale_qty' => 0,
            'min_sale_qty' => 0,
            'use_config_max_sale_qty' => 0,
            'max_sale_qty' => 1
        )
    );

$product->save();

$this->endSetup();
