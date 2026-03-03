<?php

namespace TurbineKreuzberg\Client\FeatureFlag\Reader;

use ConfigCat\ClientInterface;
use ConfigCat\User;
use TurbineKreuzberg\Client\FeatureFlag\FeatureFlagConfig;

class FeatureFlagReader
{
    public function __construct(
        private ClientInterface $configCatClient,
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
    public function getAllValues(?User $user = null): array
    {
        return $this->configCatClient->getAllValues($user);
    }
}
