<?php

namespace TurbineKreuzberg\Client\FeatureFlag\Cache;

use Exception;
use Psr\SimpleCache\CacheInterface;
use Spryker\Client\Storage\StorageClient;
use TurbineKreuzberg\Client\FeatureFlag\Exception\InvalidArgumentException;

class ConfigCatCache implements CacheInterface
{
    private StorageClient $storageClient;

    public function __construct(StorageClient $storageClient)
    {
        $this->storageClient = $storageClient;
    }

    public function get($key, $default = null): mixed
    {
        if (!is_string($key)) {
            throw new InvalidArgumentException();
        }

        return $this->storageClient->get($key);
    }

    public function set($key, $value, $ttl = null): bool
    {
        if (!is_string($key)) {
            throw new InvalidArgumentException();
        }

        try {
            $this->storageClient->set($key, $value, $ttl);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function delete($key): bool
    {
        if (!is_string($key)) {
            throw new InvalidArgumentException();
        }

        $this->storageClient->delete($key);

        return true;
    }

    public function clear(): bool
    {
        return $this->storageClient->deleteAll() > 0;
    }

    public function getMultiple($keys, $default = null): array
    {
        if (!is_array($keys)) {
           throw new InvalidArgumentException();
        }

        return $this->storageClient->getMulti($keys);
    }

    public function setMultiple($values, $ttl = null): bool
    {
        if (!is_array($values)) {
            throw new InvalidArgumentException();
        }

        try {
            $this->storageClient->setMulti($values);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function deleteMultiple($keys): bool
    {
        if (!is_array($keys)) {
            throw new InvalidArgumentException();
        }

        $this->storageClient->deleteMulti((array)$keys);

        return true;
    }

    public function has($key): bool
    {
        if (!is_string($key)) {
            throw new InvalidArgumentException();
        }

        return $this->storageClient->get($key) !== '';
    }
}
