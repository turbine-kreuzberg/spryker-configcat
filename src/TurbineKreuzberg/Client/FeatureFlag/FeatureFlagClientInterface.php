<?php

namespace TurbineKreuzberg\Client\FeatureFlag;

interface FeatureFlagClientInterface
{
    /**
     * @param string $featureName
     *
     * @return bool
     */
    public function isFeatureOn(string $featureName): bool;
}
