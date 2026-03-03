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
            ->expects($this->once())
            ->method('getValue')
            ->with('testFeatureFlag', null)
            ->willReturn(true);
        $featureFlagClientFactoryMock = $this->createMock(FeatureFlagFactory::class);
        $featureFlagClientFactoryMock
            ->expects($this->once())
            ->method('createFeatureFlagReader')
            ->willReturn($featureFlagReaderMock);

        $featureFlagClient = new FeatureFlagClient();
        $featureFlagClient->setFactory($featureFlagClientFactoryMock);

        $this->assertTrue($featureFlagClient->isFeatureOn('testFeatureFlag'));
    }

    public function testIsFeatureOff(): void
    {
        $featureFlagReaderMock = $this->createMock(FeatureFlagReader::class);
        $featureFlagReaderMock
            ->expects($this->once())
            ->method('getValue')
            ->with('testFeatureFlag', null)
            ->willReturn(false);
        $featureFlagClientFactoryMock = $this->createMock(FeatureFlagFactory::class);
        $featureFlagClientFactoryMock
            ->expects($this->once())
            ->method('createFeatureFlagReader')
            ->willReturn($featureFlagReaderMock);

        $featureFlagClient = new FeatureFlagClient();
        $featureFlagClient->setFactory($featureFlagClientFactoryMock);

        $this->assertFalse($featureFlagClient->isFeatureOn('testFeatureFlag'));
    }

    public function testIsFeatureFlagOnForUser(): void
    {
        $featureFlagReaderMock = $this->createMock(FeatureFlagReader::class);
        $featureFlagReaderMock
            ->expects($this->once())
            ->method('getValue')
            ->with('testFeatureFlag', new User(''))
            ->willReturn(false);
        $featureFlagClientFactoryMock = $this->createMock(FeatureFlagFactory::class);
        $featureFlagClientFactoryMock
            ->expects($this->once())
            ->method('createFeatureFlagReader')
            ->willReturn($featureFlagReaderMock);

        $featureFlagClient = new FeatureFlagClient();
        $featureFlagClient->setFactory($featureFlagClientFactoryMock);

        $this->assertFalse(
            $featureFlagClient->isFeatureOnForUser('testFeatureFlag', new User('')),
        );
    }

    public function testGetTextSettingReturnsTextSettingValue(): void
    {
        $featureFlagReaderMock = $this->createMock(FeatureFlagReader::class);
        $featureFlagReaderMock
            ->expects($this->once())
            ->method('getTextSetting')
            ->with('testFeatureFlag')
            ->willReturn('testFeatureFlagValue');
        $featureFlagClientFactoryMock = $this->createMock(FeatureFlagFactory::class);
        $featureFlagClientFactoryMock
            ->expects($this->once())
            ->method('createFeatureFlagReader')
            ->willReturn($featureFlagReaderMock);

        $featureFlagClient = new FeatureFlagClient();
        $featureFlagClient->setFactory($featureFlagClientFactoryMock);

        $this->assertSame(
            'testFeatureFlagValue',
            $featureFlagClient->getTextSetting('testFeatureFlag'),
        );
    }

    public function testGetAllFeatureFlagsReturnsMapWithFeatureFlagKeysAndValues(): void
    {
        $featureFlagReaderMock = $this->createMock(FeatureFlagReader::class);
        $featureFlagReaderMock
            ->expects($this->once())
            ->method('getAllFeatureFlags')
            ->willReturn(
                [
                    'booleanFeatureFlag' => true,
                    'textSetting' => 'textSettingValue',
                ],
            );

        $featureFlagClientFactoryMock = $this->createMock(FeatureFlagFactory::class);
        $featureFlagClientFactoryMock
            ->expects($this->once())
            ->method('createFeatureFlagReader')
            ->willReturn($featureFlagReaderMock);

        $featureFlagClient = new FeatureFlagClient();
        $featureFlagClient->setFactory($featureFlagClientFactoryMock);

        $this->assertSame(
            [
                'booleanFeatureFlag' => true,
                'textSetting' => 'textSettingValue',
            ],
            $featureFlagClient->getAllFeatureFlags(),
        );
    }
}
