<?php

namespace Roamtech\Gateway\Engine;

use GuzzleHttp\ClientInterface;
use Roamtech\Gateway\Auth\Authenticator;
use Roamtech\Gateway\Contracts\CacheStore;
use Roamtech\Gateway\Contracts\ConfigurationStore;
use Roamtech\Gateway\Repositories\EndpointsRepository;

/**
 * Class Core.
 *
 * @category PHP
 *
 * @author   Leitato Albert <wizqydy@gmail.com>
 */
class Core
{
    /**
     * @var ConfigurationStore
     */
    public $config;

    /**
     * @var CacheStore
     */
    public $cache;

    /**
     * @var Core
     */
    public static $instance;

    /**
     * @var ClientInterface
     */
    public $client;

    /**
     * @var Authenticator
     */
    public $auth;

    /**
     * Core constructor.
     *
     * @param ClientInterface    $client
     * @param ConfigurationStore $configStore
     * @param CacheStore         $cacheStore
     */
    public function __construct(ClientInterface $client, ConfigurationStore $configStore, CacheStore $cacheStore)
    {
        $this->config = $configStore;
        $this->cache  = $cacheStore;
        $this->setClient($client);

        $this->initialize();

        self::$instance = $this;
    }

    /**
     * Initialize the Core process.
     */
    private function initialize()
    {
        $this->auth = new Authenticator($this);
    }

    /**
     * Set http client.
     *
     * @param ClientInterface $client
     **/
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
    }
}
