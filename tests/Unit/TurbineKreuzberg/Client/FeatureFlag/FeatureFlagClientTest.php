<?php

namespace Unit\TurbineKreuzberg\Client\FeatureFlag;

use Codeception\PHPUnit\TestCase;
use ConfigCat\ConfigCatClient;
use ConfigCat\User;
use TurbineKreuzberg\Client\FeatureFlag\FeatureFlagClient;
use TurbineKreuzberg\Client\FeatureFlag\FeatureFlagFactory;

class FeatureFlagClientTest extends TestCase
{
    /**
     * @return void
     */
    public function testIsFeatureOn(): void
    {
        $configCatClientMock = $this->createMock(ConfigCatClient::class);
        $configCatClientMock
            ->expects(self::once())
            ->method('getValue')
            ->with('testFeatureFlag', false)
            ->willReturn(true);
        $featureFlagClientFactoryMock = $this->createMock(FeatureFlagFactory::class);
        $featureFlagClientFactoryMock
            ->expects(self::once())
            ->method('createConfigCatClient')
            ->willReturn($configCatClientMock);

        $featureFlagClient = new FeatureFlagClient();
        $featureFlagClient->setFactory($featureFlagClientFactoryMock);

        self::assertEquals(true, $featureFlagClient->isFeatureOn('testFeatureFlag'));
    }

    /**
     * @return void
     */
    public function testIsFeatureOff(): void
    {
        $configCatClientMock = $this->createMock(ConfigCatClient::class);
        $configCatClientMock
            ->expects(self::once())
            ->method('getValue')
            ->with('testFeatureFlag', false)
            ->willReturn(false);
        $featureFlagClientFactoryMock = $this->createMock(FeatureFlagFactory::class);
        $featureFlagClientFactoryMock
            ->expects(self::once())
            ->method('createConfigCatClient')
            ->willReturn($configCatClientMock);

        $featureFlagClient = new FeatureFlagClient();
        $featureFlagClient->setFactory($featureFlagClientFactoryMock);

        self::assertEquals(false, $featureFlagClient->isFeatureOn('testFeatureFlag'));
    }

    /**
     * @return void
     */
    public function testIsFeatureFlagOnForUser(): void
    {
        $configCatClientMock = $this->createMock(ConfigCatClient::class);
        $configCatClientMock
            ->expects(self::once())
            ->method('getValue')
            ->with('testFeatureFlag', false, new User(''))
            ->willReturn(false);
        $featureFlagClientFactoryMock = $this->createMock(FeatureFlagFactory::class);
        $featureFlagClientFactoryMock
            ->expects(self::once())
            ->method('createConfigCatClient')
            ->willReturn($configCatClientMock);

        $featureFlagClient = new FeatureFlagClient();
        $featureFlagClient->setFactory($featureFlagClientFactoryMock);

        self::assertEquals(
            false,
            $featureFlagClient->isFeatureOnForUser('testFeatureFlag', new User('')),
        );
    }
}
