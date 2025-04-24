<?php

namespace TurbineKreuzberg\Client\FeatureFlag;

use ConfigCat\User;

interface FeatureFlagClientInterface
{
    public function isFeatureOn(string $featureName): bool;

    public function isFeatureOnForUser(string $featureName, User $user): bool;
}
