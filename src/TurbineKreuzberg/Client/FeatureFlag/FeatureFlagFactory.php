<?php

namespace TurbineKreuzberg\Client\FeatureFlag;

use ConfigCat\Cache\Psr16Cache;
use ConfigCat\ClientOptions;
use ConfigCat\ConfigCatClient;
use ConfigCat\Log\LogLevel;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\Storage\StorageClientInterface;
use TurbineKreuzberg\Client\FeatureFlag\Cache\ConfigCatCache;

/**
 * @method \TurbineKreuzberg\Client\FeatureFlag\FeatureFlagConfig getConfig()
 */
class FeatureFlagFactory extends AbstractFactory
{
    public function createConfigCatClient(): ConfigCatClient
    {
        return new ConfigCatClient(
            $this->getConfig()->getSdkKey(),
            [
                ClientOptions::LOG_LEVEL => LogLevel::INFO,
                ClientOptions::CACHE => new Psr16Cache($this->createConfigCatCache()),
                ClientOptions::CACHE_REFRESH_INTERVAL => $this->getConfig()->getCacheRefreshInterval(),
            ]
        );
    }

    private function createConfigCatCache(): ConfigCatCache
    {
        return new ConfigCatCache(
            $this->getStorageClient()
        );
    }

    private function getStorageClient(): StorageClientInterface
    {
        return $this->getProvidedDependency(FeatureFlagDependencyProvider::STORAGE_CLIENT);
    }
}
