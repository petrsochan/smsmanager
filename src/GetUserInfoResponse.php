<?php

declare(strict_types=1);

namespace Pes\SmsManager;

class GetUserInfoResponse
{
    private $credit;

    private $sender;

    private $gateway;

    public function __construct($str)
    {
        $arr = explode('|', trim($str));
        $this->credit = $arr[0];
        $this->sender = $arr[1];
        $this->gateway = $arr[2];
    }

    /**
     * Get the value of credit
     */
    public function getCredit()
    {
        return $this->credit;
    }

    /**
     * Get the value of gateway
     */
    public function getGateway()
    {
        return $this->gateway;
    }

    /**
     * Get the value of sender
     */
    public function getSender()
    {
        return $this->sender;
    }
}
