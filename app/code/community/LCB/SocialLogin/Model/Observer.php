<?php
class LCB_SocialLogin_Model_Observer
{
    private function normalize($v)
    {
        $v = strtolower(trim((string)$v));
        if ($v === 'strona')     $v = 'site';
        if ($v === 'googleplus') $v = 'google';
        return in_array($v, array('site','facebook','google'), true) ? $v : 'site';
    }

    public function setLoginProviderFromPost(Varien_Event_Observer $obs)
    {
        $cust = $obs->getEvent()->getCustomer(); if (!$cust) return;
        $acc  = (array)Mage::app()->getRequest()->getPost('account', array());
        if (!isset($acc['login_provider'])) return;
        $cust->setData('login_provider', $this->normalize($acc['login_provider']));
    }

    public function beforeCustomerSave(Varien_Event_Observer $obs)
    {
        $cust = $obs->getEvent()->getCustomer(); if (!$cust) return;

        $val = $cust->getData('login_provider');
        if ($val !== null && $val !== '') {
            $cust->setData('login_provider', $this->normalize($val));
            return;
        }

        try {
            $current = $cust->getResource()->getAttributeRawValue(
                $cust->getId(), 'login_provider', $cust->getStoreId()
            );
            $cust->setData('login_provider', $current ? $this->normalize($current) : 'site');
        } catch (Exception $e) {
            $cust->setData('login_provider', 'site');
        }
    }

    public function addLoginProviderToCustomerGrid(Varien_Event_Observer $obs)
    {
        $block = $obs->getBlock();
        if (!$block instanceof Mage_Adminhtml_Block_Customer_Grid) return;

        if ($block->getColumn('login_provider')) $block->removeColumn('login_provider');

        $block->addColumnAfter('login_provider', array(
            'header'   => Mage::helper('customer')->__('Źródło konta'),
            'renderer' => 'LCB_SocialLogin_Block_Adminhtml_Renderer_LoginProvider',
            'type'     => 'options',
            'options'  => array('google'=>'Google','facebook'=>'Facebook','site'=>'Strona'),
            'sortable' => false,
            'width'    => '140px',
        ), 'group');

        if (method_exists($block, 'addColumnsOrder'))  $block->addColumnsOrder('login_provider', 'group');
        if (method_exists($block, 'sortColumnsByOrder')) $block->sortColumnsByOrder();
    }
}
