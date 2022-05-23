<?php

namespace TurbineKreuzberg\Client\FeatureFlag;

use ConfigCat\User;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \TurbineKreuzberg\Client\FeatureFlag\FeatureFlagFactory getFactory()
 */
class FeatureFlagClient extends AbstractClient implements FeatureFlagClientInterface
{
    /**
     * @param string $featureName
     *
     * @return bool
     */
    public function isFeatureOn(string $featureName): bool
    {
        return $this->getFactory()->createFeatureFlagReader()->getValue($featureName);
    }

    /**
     * @param string $featureName
     * @param \ConfigCat\User $user
     *
     * @return bool
     */
    public function isFeatureOnForUser(string $featureName, User $user): bool
    {
        return $this->getFactory()->createFeatureFlagReader()->getValue($featureName, $user);
    }
}
