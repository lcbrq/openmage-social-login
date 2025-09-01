<?php

/**
 * @author Tomasz Gregorczyk <tom@lcbrq.com>
 */

use SocialConnect\Auth\Service;
use SocialConnect\Common\HttpStack;
use SocialConnect\Provider\Session\Session;
use GuzzleHttp\Psr7\HttpFactory;
use Http\Adapter\Guzzle7\Client as GuzzleAdapter;

class LCB_SocialLogin_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getProviders(): array
    {
        $providers = [];

        if ($this->isEnabled('facebook')) {
            $providers['facebook'] = [
                    'applicationId' => $this->getApplicationId('facebook'),
                    'applicationSecret' => $this->getApplicationSecret('facebook'),
                    'scope' => ['email'],
                    'options' => [
                        'identity.fields' => [
                            'email',
                            'name',
                            'first_name',
                            'last_name',
                            'picture.width(99999)'
                        ],
                    ]
                ];
        }

        if ($this->isEnabled('google')) {
            $providers['google'] = [
                    'applicationId' => $this->getApplicationId('google'),
                    'applicationSecret' => $this->getApplicationSecret('google'),
                    'scope' => [
                        'https://www.googleapis.com/auth/userinfo.email',
                        'https://www.googleapis.com/auth/userinfo.profile'
                    ],
                ];
        }

        return $providers;
    }

    public function getConfiguration(): array
    {
        return [
            'redirectUri' => Mage::getUrl('sociallogin/authorize/${provider}'),
            'provider' => $this->getProviders(),
        ];
    }

    public function getService(): Service
    {
        $configureProviders = $this->getConfiguration();
        $httpClient = GuzzleAdapter::createWithConfig([]);
        $psr17 = new HttpFactory();

        $httpStack = new HttpStack(
            $httpClient,
            $psr17,
            $psr17
        );

        $service = new Service(
            $httpStack,
            new Session(),
            $configureProviders,
            null
        );

        return $service;

    }

    protected function isEnabled(string $provider): bool
    {
        return Mage::getStoreConfigFlag("lcb_sociallogin/$provider/enabled");
    }

    protected function getApplicationId(string $provider): ?string
    {
        return Mage::getStoreConfig("lcb_sociallogin/$provider/application_id");
    }

    protected function getApplicationSecret(string $provider): ?string
    {
        return Mage::getStoreConfig("lcb_sociallogin/$provider/application_secret");
    }

}
