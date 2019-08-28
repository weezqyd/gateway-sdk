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

    private $defaultConfig = [

        'env' => 'production',

        'api_endpoint' => 'https://api.emalify.com',

        'api_version' => 'v1',
    ];

    /**
     * Gateway configuration file.
     *
     * @var array
     */
    protected $config;

    /**
     * NativeConfig constructor.
     *
     * @param array $config
     */
    public function __construct($config = [])
    {
        if (!is_array($config)) {
            $userConfig = isset($configPath) && file_exists($configPath) ? $configPath : realpath(__DIR__ . '/../../../../../../config/roamtechapi.php');
            $config = [];
            if (\is_file($userConfig)) {
                $config = require_once $userConfig;
            }
        }
        $this->config = \array_merge($this->defaultConfig, $config);
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
     *
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $this->config[$key] = $value;
    }
}
