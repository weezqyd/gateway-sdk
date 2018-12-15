<?php
/**
 * Created by PhpStorm.
 * User: leitato
 * Date: 12/5/18
 * Time: 8:40 AM
 */

namespace Roamtech\Gateway\Api;

use Roamtech\Gateway\Engine\Core as Gateway;
use Roamtech\Gateway\Support\MakesRequest;

abstract class AbstractApi
{
    protected $gateway;

    protected $endpoint;

    use MakesRequest;

    public function __construct(Gateway $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * Get the API URL endpoint
     *
     * @param string $uri URI to append
     * @return string
     */
    protected function buildEndpoint($uri)
    {
        $version = $this->gateway->config->get('roamtechapi.api_version');
        $project = $this->gateway->config->get('roamtechapi.project_id');

        return sprintf('%s/projects/%s/%s', $version, $project, $uri);
    }
}