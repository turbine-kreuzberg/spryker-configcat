<?php

namespace TurbineKreuzberg\Client\FeatureFlag\Cache;

use Exception;
use Psr\SimpleCache\CacheInterface;
use Spryker\Client\Storage\StorageClientInterface;
use TurbineKreuzberg\Client\FeatureFlag\Exception\InvalidArgumentException;

class ConfigCatCache implements CacheInterface
{
    private StorageClientInterface $storageClient;

    /**
     * @param \Spryker\Client\Storage\StorageClientInterface $storageClient
     */
    public function __construct(StorageClientInterface $storageClient)
    {
        $this->storageClient = $storageClient;
    }

    /**
     * @param string $key
     * @param mixed $default
     *
     * @throws \TurbineKreuzberg\Client\FeatureFlag\Exception\InvalidArgumentException
     *
     * @return mixed
     */
    public function get($key, $default = null): mixed
    {
        if (!is_string($key)) {
            throw new InvalidArgumentException();
        }

        return $this->storageClient->get($key);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param int|null $ttl
     *
     * @throws \TurbineKreuzberg\Client\FeatureFlag\Exception\InvalidArgumentException
     *
     * @return bool
     */
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

    /**
     * @param string $key
     *
     * @throws \TurbineKreuzberg\Client\FeatureFlag\Exception\InvalidArgumentException
     *
     * @return bool
     */
    public function delete($key): bool
    {
        if (!is_string($key)) {
            throw new InvalidArgumentException();
        }

        $this->storageClient->delete($key);

        return true;
    }

    /**
     * @return bool
     */
    public function clear(): bool
    {
        return $this->storageClient->deleteAll() > 0;
    }

    /**
     * @param array<string> $keys
     * @param mixed $default
     *
     * @throws \TurbineKreuzberg\Client\FeatureFlag\Exception\InvalidArgumentException
     *
     * @return array<string>
     */
    public function getMultiple($keys, $default = null): array
    {
        if (!is_array($keys)) {
            throw new InvalidArgumentException();
        }

        return $this->storageClient->getMulti($keys);
    }

    /**
     * @param array<string> $values
     * @param \DateInterval|int|null $ttl
     *
     * @throws \TurbineKreuzberg\Client\FeatureFlag\Exception\InvalidArgumentException
     *
     * @return bool
     */
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

    /**
     * @param array<string> $keys
     *
     * @throws \TurbineKreuzberg\Client\FeatureFlag\Exception\InvalidArgumentException
     *
     * @return bool
     */
    public function deleteMultiple($keys): bool
    {
        if (!is_array($keys)) {
            throw new InvalidArgumentException();
        }

        $this->storageClient->deleteMulti((array)$keys);

        return true;
    }

    /**
     * @param string $key
     *
     * @throws \TurbineKreuzberg\Client\FeatureFlag\Exception\InvalidArgumentException
     *
     * @return bool
     */
    public function has($key): bool
    {
        if (!is_string($key)) {
            throw new InvalidArgumentException();
        }

        return $this->storageClient->get($key) !== '';
    }
}
