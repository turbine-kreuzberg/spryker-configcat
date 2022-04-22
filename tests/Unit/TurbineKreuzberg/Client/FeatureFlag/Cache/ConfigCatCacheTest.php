<?php

namespace Unit\TurbineKreuzberg\Client\FeatureFlag\Cache;

use Codeception\PHPUnit\TestCase;
use Exception;
use Spryker\Client\Storage\StorageClient;
use TurbineKreuzberg\Client\FeatureFlag\Cache\ConfigCatCache;
use TurbineKreuzberg\Client\FeatureFlag\Exception\InvalidArgumentException;

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

    public function testGetMethodWithWrongParameterTypeThrowsException(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::never())
            ->method('get');

        $this->expectException(InvalidArgumentException::class);

        $configCatCache = new ConfigCatCache($storageClientMock);
        $configCatCache->get(['testKey']);
    }

    public function testSetMethodReturnsTrue(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::once())
            ->method('set')
            ->with('testKey', 'testValue')
            ->willReturn(true);

        $configCatCache = new ConfigCatCache($storageClientMock);

        self::assertEquals(true, $configCatCache->set('testKey', 'testValue'));
    }

    public function testSetMethodWithWrongParameterTypeThrowsException(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::never())
            ->method('set');

        $this->expectException(InvalidArgumentException::class);

        $configCatCache = new ConfigCatCache($storageClientMock);
        $configCatCache->set(['testKey'], 'testValue');
    }

    public function testSetMethodCanNotSetValueAndReturnsFalse(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::once())
            ->method('set')
            ->willThrowException(new Exception());

        $configCatCache = new ConfigCatCache($storageClientMock);

        self::assertEquals(false, $configCatCache->set('testKey', 'testValue'));
    }

    public function testDeleteMethodReturnsTrue(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::once())
            ->method('delete')
            ->with('testKey');

        $configCatCache = new ConfigCatCache($storageClientMock);

        self::assertEquals(true, $configCatCache->delete('testKey'));
    }

    public function testDeleteMethodWithWrongParameterTypeThrowsException(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::never())
            ->method('delete');

        $this->expectException(InvalidArgumentException::class);

        $configCatCache = new ConfigCatCache($storageClientMock);
        $configCatCache->delete(['testKey']);
    }

    public function testClearMethodDeletesAllKeys(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::once())
            ->method('deleteAll')
            ->willReturn(2);

        $configCatCache = new ConfigCatCache($storageClientMock);

        self::assertEquals(true, $configCatCache->clear());
    }

    public function testClearMethodHasNothingToDelete(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::once())
            ->method('deleteAll')
            ->willReturn(0);

        $configCatCache = new ConfigCatCache($storageClientMock);

        self::assertEquals(false, $configCatCache->clear());
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
                ]
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
                ]
            )
        );
    }

    public function testGetMultipleMethodWithWrongParameterTypeThrowsException(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::never())
            ->method('getMulti');

        $this->expectException(InvalidArgumentException::class);
        $configCatCache = new ConfigCatCache($storageClientMock);
        $configCatCache->getMultiple('testKey1');
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
                    'testKey3' => 'testValue3'
                ]
            );

        $configCatCache = new ConfigCatCache($storageClientMock);

        self::assertEquals(
            true,
            $configCatCache->setMultiple(
                [
                    'testKey1' => 'testValue1',
                    'testKey2' => 'testValue2',
                    'testKey3' => 'testValue3'
                ]
            )
        );
    }

    public function testSetMultipleMethodCanNotSetValuesAndReturnsFalse(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::once())
            ->method('setMulti')
            ->willThrowException(new Exception());

        $configCatCache = new ConfigCatCache($storageClientMock);

        self::assertEquals(
            false,
            $configCatCache->setMultiple(
                [
                    'testKey1' => 'testValue1',
                    'testKey2' => 'testValue2',
                    'testKey3' => 'testValue3'
                ]
            )
        );
    }

    public function testSetMultipleMethodWithWrongParameterTypeThrowsException(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::never())
            ->method('setMulti');

        $this->expectException(InvalidArgumentException::class);

        $configCatCache = new ConfigCatCache($storageClientMock);
        $configCatCache->setMultiple('testKey1');
    }

    public function testDeleteMultipleMethodReturnsTrue(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::once())
            ->method('deleteMulti')
            ->with(['testKey1','testKey2','testKey3']);

        $configCatCache = new ConfigCatCache($storageClientMock);

        self::assertEquals(
            true,
            $configCatCache->deleteMultiple(['testKey1','testKey2','testKey3'])
        );
    }

    public function testDeleteMultipleMethodWithWrongParameterTypeThrowsException(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::never())
            ->method('deleteMulti');

        $this->expectException(InvalidArgumentException::class);

        $configCatCache = new ConfigCatCache($storageClientMock);
        $configCatCache->deleteMultiple('testKey1');
    }

    public function testHasMethodReturnsTrueIfKeyExists(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::once())
            ->method('get')
            ->with('testKey')
            ->willReturn('returnTest');

        $configCatCache = new ConfigCatCache($storageClientMock);

        self::assertEquals(true, $configCatCache->has('testKey'));
    }

    public function testHasMethodReturnsFalseIfKeyDoesNotExists(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::once())
            ->method('get')
            ->with('testKey')
            ->willReturn('');

        $configCatCache = new ConfigCatCache($storageClientMock);

        self::assertEquals(false, $configCatCache->has('testKey'));
    }

    public function testHasMethodWithWrongParameterTypeThrowsException(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::never())
            ->method('get');

        $this->expectException(InvalidArgumentException::class);

        $configCatCache = new ConfigCatCache($storageClientMock);
        $configCatCache->has(['testKey']);
    }
}
