<?php

class LCB_SocialLogin_Model_Attribute_Source_LoginProvider extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    protected $_options = array(
        array('value' => 'site',     'label' => 'Strona'),
        array('value' => 'facebook', 'label' => 'Facebook'),
        array('value' => 'google',   'label' => 'Google'),
    );

    public function getAllOptions()
    {
        return $this->_options;
    }

    public function toOptionArray()
    {
        return $this->getAllOptions();
    }

    public function getOptionText($value)
    {
        $v = (string)$value;
        foreach ($this->_options as $opt) {
            if ((string)$opt['value'] === $v) {
                return $opt['label'];
            }
        }
        return null;
    }
}
