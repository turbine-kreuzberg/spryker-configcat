<?php

namespace TurbineKreuzberg\Client\FeatureFlag;

use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;
use Spryker\Client\Storage\StorageClientInterface;

class FeatureFlagDependencyProvider extends AbstractDependencyProvider
{
    /**
     * @var string
     */
    public const STORAGE_CLIENT = 'STORAGE_CLIENT';

    public function provideServiceLayerDependencies(Container $container): Container
    {
        $container = parent::provideServiceLayerDependencies($container);

        $container = $this->addStorageClient($container);

        return $container;
    }

    private function addStorageClient(Container $container): Container
    {
        $container->set(static::STORAGE_CLIENT, function (Container $container): StorageClientInterface {
            return $container->getLocator()->storage()->client();
        });

        return $container;
    }
}
