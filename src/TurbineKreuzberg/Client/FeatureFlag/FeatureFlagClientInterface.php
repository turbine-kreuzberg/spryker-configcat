<?php

namespace TurbineKreuzberg\Client\FeatureFlag;

use ConfigCat\User;

interface FeatureFlagClientInterface
{
    /**
     * @param string $featureName
     *
     * @return bool
     */
    public function isFeatureOn(string $featureName): bool;

    /**
     * @param string $featureName
     * @param \ConfigCat\User $user
     *
     * @return bool
     */
    public function isFeatureOnForUser(string $featureName, User $user): bool;
}
