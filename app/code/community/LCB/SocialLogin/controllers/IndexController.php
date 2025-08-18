<?php

/**
 * @author Tomasz Gregorczyk <tom@lcbrq.com>
 */
class LCB_SocialLogin_IndexController extends Mage_Core_Controller_Front_Action
{
    public function authorizeAction(): void
    {
        $service = Mage::helper('lcb_sociallogin')->getService();
        $providerName = $this->getRequest()->getParam('provider');

        $provider = $service->getProvider($providerName);
        $redirectUrl = $provider->makeAuthUrl();
        Mage::app()->getResponse()->setRedirect($redirectUrl)->sendResponse();
    }

}
