<?php
/**
 * Created by PhpStorm.
 * User: leitato
 * Date: 12/5/18
 * Time: 8:36 AM
 */

namespace Roamtech\Gateway\Api\Airtime;

use Illuminate\Support\Collection;
use Roamtech\Gateway\Api\AbstractApi;
use Roamtech\Gateway\Exceptions\ErrorException;

class Transaction extends AbstractApi
{
    private $recipients;

    private $callback = null;

    /**
     * Set the airtime recipients
     *
     * @param array $recipients
     * @return $this
     * @throws ErrorException
     */
    public function setRecipients(array $recipients)
    {
        $recipients = Collection::make($recipients)->unique()->filter(function($recipient) {
            return substr((int) $recipient['phoneNumber'], 0,4) === '2547' && $recipient['amount'] >= 5;
        });

        if(!$recipients->count())
            throw new  ErrorException('Invalid airtime recipients');

        $this->recipients = $recipients->toArray();

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
        if ($url === null)
            return $this;

        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $this->callback = $url;

            return $this;
        }
        throw new ErrorException(['status' => 'error', 'message' => 'Invalid callback URL'], 400);

    }

    /**
     * @param array $recipients
     * @param null|string $callback
     * @return mixed
     * @throws ErrorException
     */
    public function purchase(array $recipients = [], $callback = null)
    {
        isset($this->recipients) ?: $this->setRecipients($recipients);
        isset($this->callback) ?: $this->setCallback($callback);
        $this->endpoint = $this->buildEndpoint('airtime/purchase');
        $params = [
            'recipients' => $this->recipients,
        ];
        if (!empty($this->callback)) {
            $params['callback'] = $this->callback;
        }

        return $this->handleRequest('POST', $params);
    }
}