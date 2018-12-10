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
}
