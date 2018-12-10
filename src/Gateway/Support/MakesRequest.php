<?php

namespace Roamtech\Gateway\Support;

use GuzzleHttp\Exception\RequestException;

trait MakesRequest
{
    /**
     * Prepare and send HTTP request.
     *
     * @param $method
     * @param array $body
     *
     * @return mixed API response
     */
    protected function handleRequest($method, $body = [])
    {
        try {
            $response = $this->makeRequest($method, $body);

            return \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $exception) {
            return \GuzzleHttp\json_decode($exception->getResponse());
        }
    }

    /**
     * Initiate the request.
     *
     * @param $method
     * @param array $body
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    private function makeRequest($method, $body = [])
    {
        return $this->gateway->client->request($method, $this->endpoint, [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$this->gateway->auth->authenticate(),
                'Content-Type' => 'application/json',
            ],
            'json' => $body,
        ]);
    }

    /**
     * Generate the result callback url.
     * The generated url is based on the values provided in the configuration.
     *
     * @param string $option
     *
     * @return string
     **/
    protected function callback($option)
    {
        $config = $this->gateway->config;
        $callback = \ltrim($config->get($option), '/');
        if ($config->get('roamtechapi.default_callbacks')) {
            $endpoint = \rtrim($config->get('roamtechapi.callbacks_endpoint'), '/');
            $callback = "{$endpoint}/{$callback}";
        }

        return $callback;
    }
}
