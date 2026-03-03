<?php

namespace TurbineKreuzberg\Client\FeatureFlag;

use Spryker\Client\Customer\CustomerClientInterface;
use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;
use Spryker\Client\Storage\StorageClientInterface;

class FeatureFlagDependencyProvider extends AbstractDependencyProvider
{
    public const string STORAGE_CLIENT = 'STORAGE_CLIENT';

    public const string CUSTOMER_CLIENT = 'CUSTOMER_CLIENT';

    public function provideServiceLayerDependencies(Container $container): Container
    {
        $container = parent::provideServiceLayerDependencies($container);
        $container = $this->addStorageClient($container);

        return $container;
    }

    private function addStorageClient(Container $container): Container
    {
        $container->set(
            static::STORAGE_CLIENT,
            function (Container $container): StorageClientInterface {
                //@phpstan-ignore-next-line
                return $container->getLocator()->storage()->client();
            },
        );

        $container->set(
            static::CUSTOMER_CLIENT,
            function (Container $container): CustomerClientInterface {
                //@phpstan-ignore-next-line
                return $container->getLocator()->customer()->client();
            },
        );

        return $container;
    }
}
