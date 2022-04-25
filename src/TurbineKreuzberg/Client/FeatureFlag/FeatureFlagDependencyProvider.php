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

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    public function provideServiceLayerDependencies(Container $container): Container
    {
        $container = parent::provideServiceLayerDependencies($container);

        $container = $this->addStorageClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    private function addStorageClient(Container $container): Container
    {
        $container->set(
            static::STORAGE_CLIENT,
            function (Container $container): StorageClientInterface {
                //@phpstan-ignore-next-line
                return $container->getLocator()->storage()->client();
            },
        );

        return $container;
    }
}
