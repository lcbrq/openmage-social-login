<?php
class LCB_SocialLogin_Block_Adminhtml_Renderer_LoginProvider
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    protected static $cache = array();

    public function render(Varien_Object $row)
    {
        try {
            $cid = (int)$row->getData('entity_id');
            if ($cid <= 0) return 'Strona';

            if (!isset(self::$cache[$cid])) {
                $customer = Mage::getModel('customer/customer')->setStoreId(0)->load($cid);
                $val = $customer && $customer->getId() ? (string)$customer->getData('login_provider') : '';
                self::$cache[$cid] = strtolower(trim($val));
            }

            $map = array('google'=>'Google','facebook'=>'Facebook','site'=>'Strona');
            return isset($map[self::$cache[$cid]]) ? $map[self::$cache[$cid]] : 'Strona';
        } catch (Exception $e) {
            Mage::logException($e);
            return 'Strona';
        }
    }
}
