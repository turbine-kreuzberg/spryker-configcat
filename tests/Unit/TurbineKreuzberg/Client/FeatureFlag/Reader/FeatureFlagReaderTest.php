<?php

namespace Unit\TurbineKreuzberg\Client\FeatureFlag\Reader;

use Codeception\Test\Unit;
use ConfigCat\ConfigCatClient;
use ConfigCat\User;
use TurbineKreuzberg\Client\FeatureFlag\FeatureFlagConfig;
use TurbineKreuzberg\Client\FeatureFlag\Reader\FeatureFlagReader;

class FeatureFlagReaderTest extends Unit
{
    /**
     * @return void
     */
    public function testReaderGetFeatureFlagValueFromLocalConfigurationFile(): void
    {
        $configCatClientMock = $this->createMock(ConfigCatClient::class);
        $configCatClientMock->expects(self::never())
            ->method('getValue');

        $featureFlagReader = new FeatureFlagReader(
            $configCatClientMock,
            new FeatureFlagConfig(),
        );

        self::assertTrue($featureFlagReader->getValue('feature_flag_in_config_file'));
    }

    /**
     * @return void
     */
    public function testReaderGetFeatureFlagValueFromConfigCatClientWithUser(): void
    {
        $configCatClientMock = $this->createMock(ConfigCatClient::class);
        $configCatClientMock->expects(self::once())
            ->method('getValue')
            ->with('feature_flag_name', false, new User('id'))
            ->willReturn(true);

        $featureFlagReader = new FeatureFlagReader(
            $configCatClientMock,
            new FeatureFlagConfig(),
        );

        self::assertTrue($featureFlagReader->getValue('feature_flag_name', new User('id')));
    }

    /**
     * @return void
     */
    public function testReaderGetFeatureFlagValueFromConfigCatClientWithoutUser(): void
    {
        $configCatClientMock = $this->createMock(ConfigCatClient::class);
        $configCatClientMock->expects(self::once())
            ->method('getValue')
            ->with('feature_flag_name', false)
            ->willReturn(true);

        $featureFlagReader = new FeatureFlagReader(
            $configCatClientMock,
            new FeatureFlagConfig(),
        );

        self::assertTrue($featureFlagReader->getValue('feature_flag_name'));
    }
}
