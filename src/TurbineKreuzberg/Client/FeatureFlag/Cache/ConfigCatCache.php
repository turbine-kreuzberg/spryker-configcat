<?php

namespace TurbineKreuzberg\Client\FeatureFlag\Cache;

use DateInterval;
use Exception;
use Psr\SimpleCache\CacheInterface;
use Spryker\Client\Storage\StorageClientInterface;
use TurbineKreuzberg\Client\FeatureFlag\Exception\InvalidArgumentException;

class ConfigCatCache implements CacheInterface
{
    public function __construct(private StorageClientInterface $storageClient)
    {
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->storageClient->get($key);
    }

    /**
     * @param \DateInterval|int|null $ttl
     */
    public function set(string $key, mixed $value, null|int|DateInterval $ttl = null): bool
    {
        try {
            if ($ttl instanceof DateInterval) {
                return false;
            }
            $this->storageClient->set($key, $value, $ttl);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function delete(string $key): bool
    {
        $this->storageClient->delete($key);

        return true;
    }

    public function clear(): bool
    {
        return $this->storageClient->deleteAll() > 0;
    }

    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        if (!is_array($keys)) {
            throw new InvalidArgumentException();
        }

        return $this->storageClient->getMulti($keys);
    }

    /**
     * @param \DateInterval|int|null $ttl
     * @param iterable<mixed, mixed> $values
     *
     * @throws \TurbineKreuzberg\Client\FeatureFlag\Exception\InvalidArgumentException
     */
    public function setMultiple(iterable $values, null|int|DateInterval $ttl = null): bool
    {
        if (!is_array($values)) {
            throw new InvalidArgumentException();
        }
        if ($ttl instanceof DateInterval) {
            return false;
        }

        try {
            $this->storageClient->setMulti($values);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function deleteMultiple(iterable $keys): bool
    {
        if (!is_array($keys)) {
            throw new InvalidArgumentException();
        }

        $this->storageClient->deleteMulti($keys);

        return true;
    }

    public function has(string $key): bool
    {
        return $this->storageClient->get($key) !== '';
    }
}
