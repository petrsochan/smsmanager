<?php
declare(strict_types=1);

namespace Pes\SmsManager;

class SendRequest
{
    const PRIORITY_HIGH = 'high';
	const PRIORITY_ECONOMY = 'economy';
	const PRIORITY_LOWCOST = 'lowcost';
	const PRIORITY_DIRECT = 'direct';

	private $gateways = [self::PRIORITY_HIGH, self::PRIORITY_ECONOMY, self::PRIORITY_LOWCOST, self::PRIORITY_DIRECT];

    /** @var array */
    private $number;

    /** @var string */
    private $message;

    /** @var string */
    private $gateway = SendRequest::PRIORITY_LOWCOST;

    /** @var string */
    private $sender;

    /** @var string */
    private $customid;

    /** @var string */
    private $time;

    /** @var string */
    private $expiration;

    public function __construct($message, $number = null, $gateway = null, 
        $sender = null, $customid = null, $time = null, $expiration = null)
    {
        if (is_array($message)) {
            foreach ($message as $k => $v) {
                $this->$k = $v;
            }
        } else {
            $this->setNumber($number);
            $this->setMessage($message);
            $this->setGateway($gateway);
            if ($sender != null) {
                $this->setSender($sender);
            }
            if ($customid != null) {
                $this->setCustomid($customid);
            }
            if ($time != null) {
                $this->setTime($time);
            }
            if ($expiration != null) {
                $this->setExpiration($expiration);
            }
        }
    }

    public function validate()
    {
        if (empty($this->number)) {
            throw new InvalidArgumentException('Number is missing');
        }
        if (!$this->isValidPhone($this->number)) {
            throw new InvalidArgumentException('Number is invalid');
        }
        if (empty(trim($this->message))) {
            throw new InvalidArgumentException('Message is missing');
        }
        if (empty(trim($this->gateway))) {
            throw new InvalidArgumentException('Gateway is missing');
        }
        if (!in_array($this->gateway, $this->gateways)) {
            throw new InvalidArgumentException('Invalid gateway - ' . $this->gateway);
        }
        if (!empty($this->customid) && strlen($this->customid) > 10) {
            throw new InvalidArgumentException('Customid maximul length is 10 characters');
        }
        if (!empty($this->time) && preg_match('/^\\d{4}-\\d{2}-\\d{2}T\\d{2}:\\d{2}:\\d{2}$/', $this->time)) {
            throw new InvalidArgumentException('Invalid time format. Valid is 2011-01-01T23:59:59');
        }
        if (!empty($this->expiration) && preg_match('/^\\d{4}-\\d{2}-\\d{2}T\\d{2}:\\d{2}:\\d{2}$/', $this->expiration)) {
            throw new InvalidArgumentException('Invalid expiration format. Valid is 2011-01-01T23:59:59');
        }
        return $this;
    }

    public function isValidPhone($number) :bool {
        return boolval(preg_match('/(\\+|00){0,1}\\d{12}|\\d{9}/', $number));
    }

    public function getNumber() {
        return $this->number;
    }

    public function setNumber($number) {
        if (is_array($number)) {
            foreach ($number as $k => $v) {
                $v = trim($v);
                if (!$this->isValidPhone($v)) {
                    throw new InvalidNumberException('Invalid number ' . $v);
                }
                $number[$k] = $v;
            }
            $this->number = $number;
        } else {
            if ($this->isValidPhone($number)) {
                $this->number = [trim($number)];
            } else {
                throw new InvalidNumberException('Invalid number ' . $number);
            }
        }
        return $this;
    }

    public function getMessage() {
        return $this->message;
    }

    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }

    public function getGateway() {
        return $this->gateway;
    }

    public function setGateway($gateway) {
        if (in_array($gateway, $this->gateways)) {
            $this->gateway = $gateway;
        }
        return $this;
    }

    public function getSender() {
        return $this->sender;
    }

    public function setSender($sender) {
        $this->sender = $sender;
        return $this;
    }

    public function getCustomid() {
        return $this->customid;
    }

    public function setCustomid($customid) {
        $this->customid = $customid;
        return $this;
    }

    public function getTime() {
        return $this->time;
    }

    public function setTime($time) {
        $this->time = $time;
        return $this;
    }

    public function getExpiration() {
        return $this->expiration;
    }

    public function setExpiration($expiration) {
        $this->expiration = $expiration;
        return $this;
    }

    public function toUrl()
    {
        $url = [];
        foreach (['number', 'message', 'gateway', 'sender', 'customid', 'time', 'expiration'] as $key) {
            if (!empty($this->$key)) {
                $url[] = $key . '=' . urlencode($this->$key);
            }
        }
        return implode('&', $url);
    }
}