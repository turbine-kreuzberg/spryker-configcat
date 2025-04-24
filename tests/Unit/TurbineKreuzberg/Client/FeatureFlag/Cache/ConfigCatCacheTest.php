<?php

namespace Unit\TurbineKreuzberg\Client\FeatureFlag\Cache;

use Codeception\PHPUnit\TestCase;
use DateInterval;
use Exception;
use Spryker\Client\Storage\StorageClient;
use TurbineKreuzberg\Client\FeatureFlag\Cache\ConfigCatCache;

class ConfigCatCacheTest extends TestCase
{
    public function testGetMethodReturnsExpectedValue(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::once())
            ->method('get')
            ->with('testKey')
            ->willReturn('returnTest');

        $configCatCache = new ConfigCatCache($storageClientMock);

        self::assertEquals('returnTest', $configCatCache->get('testKey'));
    }

    public function testSetMethodReturnsTrue(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::once())
            ->method('set')
            ->with('testKey', 'testValue')
            ->willReturn(true);

        $configCatCache = new ConfigCatCache($storageClientMock);

        self::assertTrue($configCatCache->set('testKey', 'testValue'));
    }

    public function testSetMethodWithTimeIntervalWillThrowException(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::never())
            ->method('set');

        $configCatCache = new ConfigCatCache($storageClientMock);

        self::assertFalse(
            $configCatCache->set(
                'testKey',
                'testValue',
                (new DateInterval('P7D')),
            ),
        );
    }

    public function testSetMethodCanNotSetValueAndReturnsFalse(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::once())
            ->method('set')
            ->willThrowException(new Exception());

        $configCatCache = new ConfigCatCache($storageClientMock);

        self::assertFalse($configCatCache->set('testKey', 'testValue'));
    }

    public function testDeleteMethodReturnsTrue(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::once())
            ->method('delete')
            ->with('testKey');

        $configCatCache = new ConfigCatCache($storageClientMock);

        self::assertTrue($configCatCache->delete('testKey'));
    }

    public function testClearMethodDeletesAllKeys(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::once())
            ->method('deleteAll')
            ->willReturn(2);

        $configCatCache = new ConfigCatCache($storageClientMock);

        self::assertTrue($configCatCache->clear());
    }

    public function testClearMethodHasNothingToDelete(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::once())
            ->method('deleteAll')
            ->willReturn(0);

        $configCatCache = new ConfigCatCache($storageClientMock);

        self::assertFalse($configCatCache->clear());
    }

    public function testGetMultipleMethodReturnsExpectedValues(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::once())
            ->method('getMulti')
            ->with(['testKey1', 'testKey2', 'testKey3'])
            ->willReturn(
                [
                    'testKey1' => 'returnTest1',
                    'testKey2' => 'returnTest2',
                    'testKey3' => 'returnTest3',
                ],
            );

        $configCatCache = new ConfigCatCache($storageClientMock);

        self::assertEquals(
            [
                'testKey1' => 'returnTest1',
                'testKey2' => 'returnTest2',
                'testKey3' => 'returnTest3',
            ],
            $configCatCache->getMultiple(
                [
                    'testKey1',
                    'testKey2',
                    'testKey3',
                ],
            ),
        );
    }

    public function testSetMultipleMethodReturnsExpectedValues(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::once())
            ->method('setMulti')
            ->with(
                [
                    'testKey1' => 'testValue1',
                    'testKey2' => 'testValue2',
                    'testKey3' => 'testValue3',
                ],
            );

        $configCatCache = new ConfigCatCache($storageClientMock);

        self::assertTrue(
            $configCatCache->setMultiple(
                [
                    'testKey1' => 'testValue1',
                    'testKey2' => 'testValue2',
                    'testKey3' => 'testValue3',
                ],
            ),
        );
    }

    public function testSetMultipleMethodCanNotSetValuesAndReturnsFalse(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::once())
            ->method('setMulti')
            ->willThrowException(new Exception());

        $configCatCache = new ConfigCatCache($storageClientMock);

        self::assertFalse(
            $configCatCache->setMultiple(
                [
                    'testKey1' => 'testValue1',
                    'testKey2' => 'testValue2',
                    'testKey3' => 'testValue3',
                ],
            ),
        );
    }

    public function testSetMultipleMethodCanNotBeUsedWithDateInterval(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::never())
            ->method('setMulti');

        $configCatCache = new ConfigCatCache($storageClientMock);

        self::assertFalse(
            $configCatCache->setMultiple(
                [
                    'testKey1' => 'testValue1',
                    'testKey2' => 'testValue2',
                    'testKey3' => 'testValue3',
                ],
                (new DateInterval('P7D')),
            ),
        );
    }

    public function testDeleteMultipleMethodReturnsTrue(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::once())
            ->method('deleteMulti')
            ->with(['testKey1', 'testKey2', 'testKey3']);

        $configCatCache = new ConfigCatCache($storageClientMock);

        self::assertTrue(
            $configCatCache->deleteMultiple(['testKey1', 'testKey2', 'testKey3']),
        );
    }

    public function testHasMethodReturnsTrueIfKeyExists(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::once())
            ->method('get')
            ->with('testKey')
            ->willReturn('returnTest');

        $configCatCache = new ConfigCatCache($storageClientMock);

        self::assertTrue($configCatCache->has('testKey'));
    }

    public function testHasMethodReturnsFalseIfKeyDoesNotExists(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::once())
            ->method('get')
            ->with('testKey')
            ->willReturn('');

        $configCatCache = new ConfigCatCache($storageClientMock);

        self::assertFalse($configCatCache->has('testKey'));
    }
}
