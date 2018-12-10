<?php

namespace Roamtech\Gateway\Native;

use Roamtech\Gateway\Contracts\ConfigurationStore;

/**
 * Class NativeConfig.
 *
 * @category PHP
 *
 * @author   David Mjomba <smodavprivate@gmail.com>
 */
class NativeConfig implements ConfigurationStore
{

    /**
     * Gateway configuration file.
     *
     * @var array
     */
    protected $config;

    /**
     * NativeConfig constructor.
     *
     * @param string $configPath
     */
    public function __construct($configPath = null)
    {
        $defaultConfig = require __DIR__ . '/../../../assets/config/roamtechapi.php';
        $userConfig    = $configPath ?? __DIR__ . '/../../../../../../config/roampechapi.php';
        $custom        = [];
        if (\is_file($userConfig)) {
            $custom = require $userConfig;
        }

        $this->config = \array_merge($defaultConfig, $custom);
    }

    /**
     * Get the configuration value.
     *
     * @param      $key
     * @param null $default
     *
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        $itemKey = \explode('.', $key)[1];

        if (isset($this->config[$itemKey])) {
            return $this->config[$itemKey];
        }

        return $default;
    }

    /**
     * Set config value.
     **/
    public function set($key, $value)
    {
        $this->config[$key] = $value;
    }
}
