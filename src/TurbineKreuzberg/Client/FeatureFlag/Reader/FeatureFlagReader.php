<?php

namespace TurbineKreuzberg\Client\FeatureFlag\Reader;

use ConfigCat\ConfigCatClient;
use ConfigCat\User;
use TurbineKreuzberg\Client\FeatureFlag\FeatureFlagConfig;

class FeatureFlagReader
{
    public function __construct(
        private ConfigCatClient $configCatClient,
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
}
