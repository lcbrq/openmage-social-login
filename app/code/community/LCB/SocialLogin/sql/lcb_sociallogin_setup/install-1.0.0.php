<?php

/** @var Mage_Customer_Model_Entity_Setup $installer */
$installer = $this;
$installer->startSetup();

$attributeCode = LCB_SocialLogin_Helper_Data::ATTRIBUTE_CODE;

if (!$installer->getAttributeId('customer', $attributeCode)) {
    $installer->addAttribute('customer', $attributeCode, array(
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

    $attribute = Mage::getSingleton('eav/config')->getAttribute('customer', $attributeCode);
    $attribute->setData('used_in_forms', array('adminhtml_customer'));
    $attribute->save();
}

$installer->endSetup();
