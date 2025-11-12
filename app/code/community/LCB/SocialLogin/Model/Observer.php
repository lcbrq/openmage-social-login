<?php

class LCB_SocialLogin_Model_Observer
{
    public function addLoginProviderToCustomerGrid(Varien_Event_Observer $obs)
    {
        $block = $obs->getBlock();
        if (!$block instanceof Mage_Adminhtml_Block_Customer_Grid) {
            return;
        }

        if ($block->getColumn('login_provider')) {
            $block->removeColumn('login_provider');
        }

        $block->addColumnAfter('login_provider', array(
            'header'   => Mage::helper('customer')->__('Źródło konta'),
            'renderer' => 'LCB_SocialLogin_Block_Adminhtml_Renderer_LoginProvider',
            'type'     => 'options',
            'options'  => array('google' => 'Google','facebook' => 'Facebook','site' => 'Strona'),
            'sortable' => false,
            'width'    => '140px',
        ), 'group');

        if (method_exists($block, 'addColumnsOrder')) {
            $block->addColumnsOrder('login_provider', 'group');
        }
        if (method_exists($block, 'sortColumnsByOrder')) {
            $block->sortColumnsByOrder();
        }
    }
}
