<?php

namespace TurbineKreuzberg\Client\FeatureFlag;

interface FeatureFlagClientInterface
{
    public function isFeatureOn(string $featureName): bool;
}
