<?php

namespace Roamtech\Gateway\Laravel\Stores;

use Illuminate\Config\Repository;
use Roamtech\Gateway\Contracts\ConfigurationStore;

/**
 * Class LaravelConfig
 *
 * @category PHP
 *
 * @author   Leitato Albert <wizqydy@gmail.com>
 */
class LaravelConfig implements ConfigurationStore
{
    /**
     * @var Repository
     */
    private $repository;

    /**
     * LaravelConfiguration constructor.
     *
     * @param Repository $repository
     */
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get given config value from the configuration store.
     *
     * @param string $key
     * @param null $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->repository->get($key, $default);
    }

    /**
     * Set given config value in the configuration store.
     *
     * @param string $key
     * @param $value
     */
    public function set($key, $value)
    {
        $this->repository->set($key, $value);
    }
}
