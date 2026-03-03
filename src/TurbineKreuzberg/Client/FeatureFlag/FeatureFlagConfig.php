<?php

namespace TurbineKreuzberg\Client\FeatureFlag;

use Spryker\Client\Kernel\AbstractBundleConfig;
use TurbineKreuzberg\Shared\FeatureFlag\FeatureFlagConstants;

class FeatureFlagConfig extends AbstractBundleConfig
{
    public function getSdkKey(): string
    {
        return $this->get(FeatureFlagConstants::SDK_KEY);
    }

    public function getCacheRefreshInterval(): int
    {
        return (int)$this->get(FeatureFlagConstants::CACHE_REFRESH_INTERVAL, 2592000);
    }

    public function areFeatureFlagsDefinedInConfigFile(): bool
    {
        $configCatFeatureFlags = $this->get(FeatureFlagConstants::CONFIG_CAT_FEATURE_FLAGS, []);

        if (is_array($configCatFeatureFlags) === false) {
            return false;
        }

        return count($configCatFeatureFlags) > 0;
    }

    public function isFeatureFlagExistInConfigFile(string $featureName): bool
    {
        $configCatFeatureFlags = $this->get(FeatureFlagConstants::CONFIG_CAT_FEATURE_FLAGS, []);

        if (is_array($configCatFeatureFlags) === false) {
            return false;
        }

        return isset($configCatFeatureFlags[$featureName]);
    }

    /**
     * @return array<string, string|bool>
     */
    public function getFeatureFlagsFromConfigFile(): array
    {
        $configCatFeatureFlags = $this->get(FeatureFlagConstants::CONFIG_CAT_FEATURE_FLAGS, []);

        if (is_array($configCatFeatureFlags) === false) {
            return [];
        }

        return $configCatFeatureFlags;
    }

    public function getFeatureFlagFromConfigFile(string $featureName): bool
    {
        $configCatFeatureFlags = $this->get(FeatureFlagConstants::CONFIG_CAT_FEATURE_FLAGS, []);

        if (is_array($configCatFeatureFlags) === false) {
            return false;
        }

        return (bool)$configCatFeatureFlags[$featureName];
    }

    public function getTextSettingFromConfigFile(string $featureName): string
    {
        $configCatFeatureFlags = $this->get(FeatureFlagConstants::CONFIG_CAT_FEATURE_FLAGS, []);

        if (is_array($configCatFeatureFlags) === false) {
            return '';
        }

        return (string)$configCatFeatureFlags[$featureName];
    }
}
