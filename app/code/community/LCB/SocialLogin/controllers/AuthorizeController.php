<?php

/**
 * @author Tomasz Gregorczyk <tom@lcbrq.com>
 */
class LCB_SocialLogin_AuthorizeController extends Mage_Core_Controller_Front_Action
{
    public function googleAction(): self
    {
        $service = Mage::helper('lcb_sociallogin')->getService();
        $provider = $service->getProvider('google');
        $accessToken = $provider->getAccessTokenByRequestParameters($this->getRequest()->getParams());
        $user = $provider->getIdentity($accessToken);
        $customer = Mage::getModel('lcb_sociallogin/customer')->getOrCreateFromSocialLogin($user, 'google');
        Mage::getSingleton('customer/session')->loginById($customer->getId());
        return $this->_redirect('customer/account');
    }

    public function facebookAction(): self
    {
        $service = Mage::helper('lcb_sociallogin')->getService();
        $provider = $service->getProvider('facebook');
        $accessToken = $provider->getAccessTokenByRequestParameters($this->getRequest()->getParams());
        $user = $provider->getIdentity($accessToken);
        $customer = Mage::getModel('lcb_sociallogin/customer')->getOrCreateFromSocialLogin($user, 'facebook');
        Mage::getSingleton('customer/session')->loginById($customer->getId());
        return $this->_redirect('customer/account');
    }

}
