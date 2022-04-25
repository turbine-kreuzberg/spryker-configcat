<?php

namespace TurbineKreuzberg\Client\FeatureFlag;

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
        return $this->getFactory()->createConfigCatClient()->getValue($featureName, false);
    }
}
