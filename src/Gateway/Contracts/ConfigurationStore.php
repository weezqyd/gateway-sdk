<?php

namespace Roamtech\Gateway\Contracts;

/**
 * Interface ConfigurationStore
 *
 * @category PHP
 *
 * @author   Leitato Albert <wizqydy@gmail.com>
 */
interface ConfigurationStore
{
    /**
     * Get the configuration value from the store or a default value to be supplied.
     *
     * @param $key
     * @param $default
     *
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * Set the configuration value in the store .
     *
     * @param string $key
     * @param string $value
     *
     * @return mixed
     */
    public function set($key, $value);
}
