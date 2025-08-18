<?php

use SocialConnect\Common\Entity\User;

class LCB_SocialLogin_Model_Customer extends Mage_Customer_Model_Customer
{
    public function getOrCreateFromSocialLogin(User $user, string $provider): self
    {
        $email = $user->email;

        $this->setWebsiteId(Mage::app()->getStore()->getWebsiteId())->loadByEmail($email);

        if (!$this->getId()) {
            $this->setEmail($email);
            $this->setFirstname($user->firstname);
            $this->setLastname($user->lastname);
            $this->setPassword($this->generatePassword());
            $this->setLoginProvider($provider);
            $this->setSkipConfirmationIfEmail($email);
            $this->setForceConfirmed(true);
            $this->save();
        }

        return $this;
    }

}
