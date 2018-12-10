<?php

namespace Roamtech\Gateway\Auth;

use GuzzleHttp\Exception\RequestException;
use Roamtech\Gateway\Engine\Core;
use Roamtech\Gateway\Exceptions\ErrorException;
use Roamtech\Gateway\Exceptions\ConfigurationException;

/**
 * Class Authenticator.
 *
 * @category PHP
 *
 * @author   Leitato Albert <wizqydy@gmail.com>
 */
class Authenticator
{
    /**
     * Cache key.
     */
    const AC_TOKEN = 'RG_AC_T';

    /**
     * @var string
     */
    protected $endpoint = '/v1/oauth/token';

    /**
     * @var Core
     */
    protected $engine;

    /**
     * @var Authenticator
     */
    protected static $instance;

    /**
     * Authenticator constructor.
     *
     * @param Core $core
     */
    public function __construct(Core $core)
    {
        $this->engine = $core;
        static::$instance = $this;
    }

    /**
     * @return mixed
     * @throws ConfigurationException
     * @throws ErrorException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function authenticate()
    {
        if ($token = $this->engine->cache->get(static::AC_TOKEN)) {
            return $token;
        }

        try {
            $response = $this->makeRequest();

            $body = \GuzzleHttp\json_decode($response->getBody());
            $this->saveCredentials($body);

            return $body->access_token;
        } catch (RequestException $exception) {
            $message = $exception->getResponse() ?
               $exception->getResponse()->getReasonPhrase() :
               $exception->getMessage();

            throw $this->generateException($message);
        }
    }

    /**
     * Throw a contextual exception.
     *
     * @param $reason
     *
     * @return ErrorException|ConfigurationException
     */
    private function generateException($reason)
    {
        switch (\strtolower($reason)) {
            case 'bad request: invalid credentials':
                return new ConfigurationException('Invalid client key and secret combination');
            default:
                return new ErrorException($reason);
        }
    }

    /**
     * Generate the base64 encoded authorization key.
     *
     * @return array
     */
    private function generateCredentials()
    {
        $key = $this->engine->config->get('roamtechapi.client_id');
        $secret = $this->engine->config->get('roamtechapi.client_secret');

        return [
            'client_id' => $key,
            'client_secret' => $secret,
            'grant_type' => 'client_credentials'
        ];
    }

    /**
     * Initiate the authentication request.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function makeRequest()
    {
        $credentials = $this->generateCredentials();

        return $this->engine->client->request('POST', $this->endpoint, [
            'json' => $credentials,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * Store the credentials in the cache.
     *
     * @param $credentials
     */
    private function saveCredentials($credentials)
    {
        $ttl = (int) ($credentials->expires_in / 60) - 2;

        $this->engine->cache->put(static::AC_TOKEN, $credentials->access_token, $ttl);
    }
}
