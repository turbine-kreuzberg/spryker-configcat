<?php

namespace TurbineKreuzberg\Client\FeatureFlag\Reader;

use ConfigCat\ConfigCatClient;
use ConfigCat\User;
use TurbineKreuzberg\Client\FeatureFlag\FeatureFlagConfig;

class FeatureFlagReader
{
    private ConfigCatClient $configCatClient;

    private FeatureFlagConfig $config;

    /**
     * @param \ConfigCat\ConfigCatClient $configCatClient
     * @param \TurbineKreuzberg\Client\FeatureFlag\FeatureFlagConfig $config
     */
    public function __construct(
        ConfigCatClient $configCatClient,
        FeatureFlagConfig $config
    ) {
        $this->configCatClient = $configCatClient;
        $this->config = $config;
    }

    /**
     * @param string $featureName
     * @param \ConfigCat\User|null $user
     *
     * @return bool
     */
    public function getValue(string $featureName, ?User $user = null): bool
    {
        if ($this->config->isFeatureFlagExistInConfigFile($featureName)) {
            return $this->config->getFeatureFlagFromConfigFile($featureName);
        }

        return $this->configCatClient->getValue($featureName, false, $user);
    }
}
