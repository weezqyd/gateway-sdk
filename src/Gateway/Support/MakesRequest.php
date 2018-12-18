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
            throw $exception;
            //return //\GuzzleHttp\json_decode($exception->getResponse()->getBody()->getContents());
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

}
