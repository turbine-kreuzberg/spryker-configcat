<?php

namespace TurbineKreuzberg\Client\FeatureFlag;

use Spryker\Client\Kernel\AbstractBundleConfig;
use TurbineKreuzberg\Shared\FeatureFlag\FeatureFlagConstants;

class FeatureFlagConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getSdkKey(): string
    {
        return $this->get(FeatureFlagConstants::SDK_KEY);
    }

    /**
     * @return int
     */
    public function getCacheRefreshInterval(): int
    {
        return (int)$this->get(FeatureFlagConstants::CACHE_REFRESH_INTERVAL, 2592000);
    }

    /**
     * @param string $featureName
     *
     * @return bool
     */
    public function isFeatureFlagExistInConfigFile(string $featureName): bool
    {
        $configCatFeatureFlags = $this->get(FeatureFlagConstants::CONFIG_CAT_FEATURE_FLAGS, []);

        return isset($configCatFeatureFlags[$featureName]);
    }

    /**
     * @param string $featureName
     *
     * @return bool
     */
    public function getFeatureFlagFromConfigFile(string $featureName): bool
    {
        $configCatFeatureFlags = $this->get(FeatureFlagConstants::CONFIG_CAT_FEATURE_FLAGS);

        return (bool)$configCatFeatureFlags[$featureName];
    }
}
