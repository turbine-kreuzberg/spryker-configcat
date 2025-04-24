<?php

namespace Unit\TurbineKreuzberg\Client\FeatureFlag;

use Codeception\PHPUnit\TestCase;
use ConfigCat\User;
use TurbineKreuzberg\Client\FeatureFlag\FeatureFlagClient;
use TurbineKreuzberg\Client\FeatureFlag\FeatureFlagFactory;
use TurbineKreuzberg\Client\FeatureFlag\Reader\FeatureFlagReader;

class FeatureFlagClientTest extends TestCase
{
    public function testIsFeatureOn(): void
    {
        $featureFlagReaderMock = $this->createMock(FeatureFlagReader::class);
        $featureFlagReaderMock
            ->expects(self::once())
            ->method('getValue')
            ->with('testFeatureFlag', null)
            ->willReturn(true);
        $featureFlagClientFactoryMock = $this->createMock(FeatureFlagFactory::class);
        $featureFlagClientFactoryMock
            ->expects(self::once())
            ->method('createFeatureFlagReader')
            ->willReturn($featureFlagReaderMock);

        $featureFlagClient = new FeatureFlagClient();
        $featureFlagClient->setFactory($featureFlagClientFactoryMock);

        self::assertTrue($featureFlagClient->isFeatureOn('testFeatureFlag'));
    }

    public function testIsFeatureOff(): void
    {
        $featureFlagReaderMock = $this->createMock(FeatureFlagReader::class);
        $featureFlagReaderMock
            ->expects(self::once())
            ->method('getValue')
            ->with('testFeatureFlag', null)
            ->willReturn(false);
        $featureFlagClientFactoryMock = $this->createMock(FeatureFlagFactory::class);
        $featureFlagClientFactoryMock
            ->expects(self::once())
            ->method('createFeatureFlagReader')
            ->willReturn($featureFlagReaderMock);

        $featureFlagClient = new FeatureFlagClient();
        $featureFlagClient->setFactory($featureFlagClientFactoryMock);

        self::assertFalse($featureFlagClient->isFeatureOn('testFeatureFlag'));
    }

    public function testIsFeatureFlagOnForUser(): void
    {
        $featureFlagReaderMock = $this->createMock(FeatureFlagReader::class);
        $featureFlagReaderMock
            ->expects(self::once())
            ->method('getValue')
            ->with('testFeatureFlag', new User(''))
            ->willReturn(false);
        $featureFlagClientFactoryMock = $this->createMock(FeatureFlagFactory::class);
        $featureFlagClientFactoryMock
            ->expects(self::once())
            ->method('createFeatureFlagReader')
            ->willReturn($featureFlagReaderMock);

        $featureFlagClient = new FeatureFlagClient();
        $featureFlagClient->setFactory($featureFlagClientFactoryMock);

        self::assertFalse(
            $featureFlagClient->isFeatureOnForUser('testFeatureFlag', new User('')),
        );
    }
}
