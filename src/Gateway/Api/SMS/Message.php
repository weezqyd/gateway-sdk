<?php
/**
 * Created by PhpStorm.
 * User: leitato
 * Date: 12/4/18
 * Time: 3:58 PM
 */

namespace Roamtech\Gateway\Api\SMS;

use Roamtech\Gateway\Api\AbstractApi;

class Message extends AbstractApi
{
    public function sendMessage($message, array $recipients, array $options = [])
    {
        $this->endpoint = $this->buildEndpoint('sms/simple/send');
        $params = array_merge($options, [
            'message' => $message,
            'to' => $recipients
        ]);

        return $this->handleRequest('POST', $params);
    }

    public function sendPremiumMessage($message, array $recipients, array $options = [])
    {
        $this->endpoint = $this->buildEndpoint('sms/premium/send');
        $params = array_merge($options, [
            'message' => $message,
            'to' => $recipients
        ]);

        return $this->handleRequest('POST', $params);
    }

    public function sendBulkMessages($payload, array $options = [])
    {
        $messages = $this->validateBulkPayLoad($payload);
        $params = array_merge([
            'messages' => $messages,
        ], $options);
        $this->endpoint = $this->buildEndpoint('sms/bulk');

        return $this->handleRequest('POST', $params);
    }

    /**
     * @param $messageId
     * @return mixed
     */
    public function getDeliveryReport($messageId)
    {
        $this->endpoint = $this->buildEndpoint('sms/delivery-reports?messageId='.$messageId);

        return $this->handleRequest('GET', []);
    }

    /**
     * @param array $payload
     * @return array
     */
    private function validateBulkPayLoad(array $payload)
    {
        return array_filter($payload, function ($message) {
            return is_array($message) && key_exists('message', $message) && key_exists('recipient', $message);
        });
    }
}
