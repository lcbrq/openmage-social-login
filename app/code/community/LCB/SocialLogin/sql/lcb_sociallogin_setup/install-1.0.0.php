<?php

/** @var Mage_Customer_Model_Entity_Setup $installer */
$installer = $this;
$installer->startSetup();

$attrCode = 'login_provider';

if (!$installer->getAttributeId('customer', $attrCode)) {
    $installer->addAttribute('customer', $attrCode, array(
        'type'         => 'varchar',
        'label'        => 'Login Provider',
        'input'        => 'select',
        'visible'      => true,
        'required'     => false,
        'user_defined' => true,
        'position'     => 999,
        'default'      => 'site',
        'source'       => 'lcb_sociallogin/attribute_source_loginProvider',
        'system'       => 0,
    ));

    $attribute = Mage::getSingleton('eav/config')->getAttribute('customer', $attrCode);
    $attribute->setData('used_in_forms', array('adminhtml_customer'));
    $attribute->save();
}

$installer->endSetup();
