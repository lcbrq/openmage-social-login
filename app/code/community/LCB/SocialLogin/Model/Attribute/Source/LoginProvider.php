<?php

class LCB_SocialLogin_Model_Attribute_Source_LoginProvider extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    /**
     * @return array
     */
    public function getAllOptions()
    {
        return array(
            array('value' => 'site', 'label' => Mage::helper('cms')->__('Page')),
            array('value' => 'facebook', 'label' => 'Facebook'),
            array('value' => 'google', 'label' => 'Google'),
        );
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return $this->getAllOptions();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $options = [];

        foreach ($this->getAllOptions() as $option) {
            $options[$option['value']] = $option['label'];
        }

        return $options;
    }
}
