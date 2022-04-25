<?php

namespace Unit\TurbineKreuzberg\Client\FeatureFlag\Cache;

use Codeception\PHPUnit\TestCase;
use Exception;
use Spryker\Client\Storage\StorageClient;
use TurbineKreuzberg\Client\FeatureFlag\Cache\ConfigCatCache;
use TurbineKreuzberg\Client\FeatureFlag\Exception\InvalidArgumentException;

class ConfigCatCacheTest extends TestCase
{
    /**
     * @return void
     */
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

    /**
     * @return void
     */
    public function testGetMethodWithWrongParameterTypeThrowsException(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::never())
            ->method('get');

        $this->expectException(InvalidArgumentException::class);

        $configCatCache = new ConfigCatCache($storageClientMock);
        //@phpstan-ignore-next-line
        $configCatCache->get(['testKey']);
    }

    /**
     * @return void
     */
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

    /**
     * @return void
     */
    public function testSetMethodWithWrongParameterTypeThrowsException(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::never())
            ->method('set');

        $this->expectException(InvalidArgumentException::class);

        $configCatCache = new ConfigCatCache($storageClientMock);
        //@phpstan-ignore-next-line
        $configCatCache->set(['testKey'], 'testValue');
    }

    /**
     * @return void
     */
    public function testSetMethodCanNotSetValueAndReturnsFalse(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::once())
            ->method('set')
            ->willThrowException(new Exception());

        $configCatCache = new ConfigCatCache($storageClientMock);

        self::assertEquals(false, $configCatCache->set('testKey', 'testValue'));
    }

    /**
     * @return void
     */
    public function testDeleteMethodReturnsTrue(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::once())
            ->method('delete')
            ->with('testKey');

        $configCatCache = new ConfigCatCache($storageClientMock);

        self::assertEquals(true, $configCatCache->delete('testKey'));
    }

    /**
     * @return void
     */
    public function testDeleteMethodWithWrongParameterTypeThrowsException(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::never())
            ->method('delete');

        $this->expectException(InvalidArgumentException::class);

        $configCatCache = new ConfigCatCache($storageClientMock);
        //@phpstan-ignore-next-line
        $configCatCache->delete(['testKey']);
    }

    /**
     * @return void
     */
    public function testClearMethodDeletesAllKeys(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::once())
            ->method('deleteAll')
            ->willReturn(2);

        $configCatCache = new ConfigCatCache($storageClientMock);

        self::assertEquals(true, $configCatCache->clear());
    }

    /**
     * @return void
     */
    public function testClearMethodHasNothingToDelete(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::once())
            ->method('deleteAll')
            ->willReturn(0);

        $configCatCache = new ConfigCatCache($storageClientMock);

        self::assertEquals(false, $configCatCache->clear());
    }

    /**
     * @return void
     */
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

    /**
     * @return void
     */
    public function testGetMultipleMethodWithWrongParameterTypeThrowsException(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::never())
            ->method('getMulti');

        $this->expectException(InvalidArgumentException::class);
        $configCatCache = new ConfigCatCache($storageClientMock);
        //@phpstan-ignore-next-line
        $configCatCache->getMultiple('testKey1');
    }

    /**
     * @return void
     */
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

        self::assertEquals(
            true,
            $configCatCache->setMultiple(
                [
                    'testKey1' => 'testValue1',
                    'testKey2' => 'testValue2',
                    'testKey3' => 'testValue3',
                ],
            ),
        );
    }

    /**
     * @return void
     */
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
                    'testKey3' => 'testValue3',
                ],
            ),
        );
    }

    /**
     * @return void
     */
    public function testSetMultipleMethodWithWrongParameterTypeThrowsException(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::never())
            ->method('setMulti');

        $this->expectException(InvalidArgumentException::class);

        $configCatCache = new ConfigCatCache($storageClientMock);
        //@phpstan-ignore-next-line
        $configCatCache->setMultiple('testKey1');
    }

    /**
     * @return void
     */
    public function testDeleteMultipleMethodReturnsTrue(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::once())
            ->method('deleteMulti')
            ->with(['testKey1', 'testKey2', 'testKey3']);

        $configCatCache = new ConfigCatCache($storageClientMock);

        self::assertEquals(
            true,
            $configCatCache->deleteMultiple(['testKey1', 'testKey2', 'testKey3']),
        );
    }

    /**
     * @return void
     */
    public function testDeleteMultipleMethodWithWrongParameterTypeThrowsException(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::never())
            ->method('deleteMulti');

        $this->expectException(InvalidArgumentException::class);

        $configCatCache = new ConfigCatCache($storageClientMock);
        //@phpstan-ignore-next-line
        $configCatCache->deleteMultiple('testKey1');
    }

    /**
     * @return void
     */
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

    /**
     * @return void
     */
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

    /**
     * @return void
     */
    public function testHasMethodWithWrongParameterTypeThrowsException(): void
    {
        $storageClientMock = $this->createMock(StorageClient::class);
        $storageClientMock->expects(self::never())
            ->method('get');

        $this->expectException(InvalidArgumentException::class);

        $configCatCache = new ConfigCatCache($storageClientMock);
        //@phpstan-ignore-next-line
        $configCatCache->has(['testKey']);
    }
}
