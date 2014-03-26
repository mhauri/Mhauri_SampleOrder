<?php

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
