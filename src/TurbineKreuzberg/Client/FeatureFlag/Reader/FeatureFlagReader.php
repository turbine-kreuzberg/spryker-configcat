<?php

namespace TurbineKreuzberg\Client\FeatureFlag\Reader;

use ConfigCat\ClientInterface;
use ConfigCat\User;
use Spryker\Client\Customer\CustomerClientInterface;
use TurbineKreuzberg\Client\FeatureFlag\FeatureFlagConfig;

class FeatureFlagReader
{
    public function __construct(
        private ClientInterface $configCatClient,
        private CustomerClientInterface $customerClient,
        private FeatureFlagConfig $config
    ) {
    }

    public function getValue(string $featureName, ?User $user = null): bool
    {
        if ($this->config->isFeatureFlagExistInConfigFile($featureName)) {
            return $this->config->getFeatureFlagFromConfigFile($featureName);
        }

        return $this->configCatClient->getValue($featureName, false, $user);
    }

    public function isFeatureOnForUserInSession(string $featureName): bool
    {
        if ($this->customerClient->isLoggedIn() === false) {
            return $this->getValue($featureName);
        }

        $sessionCustomer = $this->customerClient->getCustomer();
        if ($sessionCustomer === null) {
            return false;
        }

        if ($sessionCustomer->getEmail() === null) {
            return false;
        }

        return $this->getValue(
            $featureName,
            new User($sessionCustomer->getEmail()),
        );
    }

    public function getTextSetting(string $featureName): string
    {
        if ($this->config->isFeatureFlagExistInConfigFile($featureName)) {
            return $this->config->getTextSettingFromConfigFile($featureName);
        }

        $value = $this->configCatClient->getValue($featureName, '');

        if (!is_string($value)) {
            return '';
        }

        return $value;
    }

    /**
     * @return array<string, bool|string>
     */
    public function getAllFeatureFlags(): array
    {
        if ($this->config->areFeatureFlagsDefinedInConfigFile() === true) {
            return $this->config->getFeatureFlagsFromConfigFile();
        }

        $user = $this->getCurrentUser();

        return $this->configCatClient->getAllValues($user);
    }

    private function getCurrentUser(): ?User
    {
        $sessionCustomer = $this->customerClient->getCustomer();

        if ($sessionCustomer === null) {
            return null;
        }

        $email = $sessionCustomer->getEmail();
        if ($email === null) {
            return null;
        }

        return new User($email);
    }
}
