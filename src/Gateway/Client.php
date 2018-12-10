<?php

namespace Roamtech\Gateway;

use Roamtech\Gateway\Engine\Core as Gateway;

/**
 * Exposes the core API functionality.
 *
 * @author Leitato Albert <wizqydy@gmail.com>
 */
class Client
{
    /**
     * The Core Class.
     *
     * @var Gateway
     **/
    protected $gateway;

    public function __construct(Gateway $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * Expose the SMS API.
     **/
    public function sms()
    {
        return new Api\SMS\Message($this->gateway);
    }
}
