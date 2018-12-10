<?php
/**
 * Created by PhpStorm.
 * User: leitato
 * Date: 12/5/18
 * Time: 8:36 AM
 */

namespace Roamtech\Gateway\Api\Airtime;

use Roamtech\Gateway\Api\AbstractApi;
use Roamtech\Gateway\Exceptions\ErrorException;

class Transaction extends AbstractApi
{
    private $recipients;

    private $amount;

    private $callback = null;

    public function setRecipients(array $recipients)
    {
        $recipients = array_filter(array_unique($recipients), function($number) {
            return substr((int)$number, 0,4) === 2547;
        });

        $this->recipients = $recipients;

        return $this;
    }

    /**
     * @param float $amount
     * @return $this
     */
    public function setAmount(float $amount)
    {
        $this->amount = $amount * 100;

        return $this;
    }

    /**
     * @param $url
     * @return $this
     *
     * @throws ErrorException
     */
    public function setCallback($url = null)
    {
        if($url === null)
            return $this;

        if(filter_var($url, FILTER_VALIDATE_URL)) {
            $this->callback = $url;

            return $this;
        }
        throw new ErrorException(['status' => 'error', 'message' => 'Invalid callback URL'], 400);

    }

    /**
     * @param null|int $amount
     * @param array $recipients
     * @param null|string $callback
     * @return mixed
     * @throws ErrorException
     */
    public function purchase($amount = null, array $recipients = [], $callback = null)
    {
        $this->amount ?: $this->setAmount($amount);
        $this->recipients ?: $this->setRecipients($recipients);
        $this->callback ?: $this->setCallback($callback);
        $this->endpoint = $this->buildEndpoint('airtime/purchase');
        $params = [
            'recipients' => $recipients,
            'amount' => $amount
        ];
        if($callback = $this->callback) {
            $params['callback'] = $callback;
        }

        return $this->handleRequest('POST', $params);
    }
}