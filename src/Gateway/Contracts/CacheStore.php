<?php

namespace Roamtech\Gateway\Contracts;

interface CacheStore
{
    /**
     * Get the cache value from the store or a default value to be supplied.
     *
     * @param $key
     * @param $default
     *
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * Store an item in the cache.
     *
     * @param string                                     $key
     * @param mixed                                      $value
     * @param \DateTimeInterface|\DateInterval|float|int $seconds
     */
    public function put($key, $value, $seconds = null);
}
