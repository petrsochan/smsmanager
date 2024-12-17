<?php

declare(strict_types=1);

namespace Pes\SmsManager;

use Pes\SmsManager\Exception\CommunicationException;
use Pes\SmsManager\Exception\InvalidArgumentException;
use Pes\SmsManager\Exception\InvalidStateException;

class SmsManager
{
    /** @var string */
    private $apikey;

    /** @var string */
    private $defaultSender;

    const API_URL = 'https://http-api.smsmanager.cz';
    const USER_AGENT = 'SmsManager PHP';
    const ACTION_SEND = 'Send';
    const ACTION_GET_USER_INFO = 'GetUserInfo';

    /**
     * @param string $apikey
     */
    public function __construct($apikey)
    {
        if (empty($apikey)) {
            throw new InvalidArgumentException('Empty API key.');
        }
        $this->apikey = $apikey;
    }

    public function getApikey()
    {
        return $this->apikey;
    }

    public function setApikey($apikey)
    {
        $this->apikey = $apikey;
        return $this;
    }

    public function getDefaultSender()
    {
        return $this->defaultSender;
    }

    public function setDefaultSender($defaultSender)
    {
        $this->defaultSender = $defaultSender;
        return $this;
    }

    public function getUserInfo()
    {
        $url = self::API_URL . '/' . self::ACTION_GET_USER_INFO . '?apikey=' . $this->apikey;
        return new GetUserInfoResponse($this->getRequest($url));
    }

    /**
     * @param SendRequest|String $request
     * @return SendResponse $response
     */
    public function send(
        $request,
        $number = null,
        $gateway = null,
        $sender = null,
        $customid = null,
        $time = null,
        $expiration = null
    ) {
        if (!($request instanceof SendRequest)) {
            $request = new SendRequest($request, $number, $gateway, $sender, $customid, $time, $expiration);
        }
        $url = self::API_URL . '/' . self::ACTION_SEND . '?apikey=' . $this->apikey . '&' . $request->toUrl();
        $response = new SendResponse($this->getRequest($url));
        if ($response->getResult() != SendResponse::RESULT_OK) {
            throw new InvalidStateException($response->getErrorMessage());
        }
        return $response;
    }

    /**
     * @param string $url
     * @param string $method
     * @param string $data|NULL
     * @return string|bool
     * @throws CommunicationException
     */
    protected function makeRequest($url, $method = 'GET', $data = NULL)
    {
        $curl = curl_init();

        $curlOpt = array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => self::USER_AGENT,
        );

        if ($method === 'POST') {
            $curlOpt[CURLOPT_POST] = 1;
            $curlOpt[CURLOPT_POSTFIELDS] = $data;
        }

        curl_setopt_array($curl, $curlOpt);
        $response = curl_exec($curl);
        curl_close($curl);

        if ($response === false) {
            throw new CommunicationException();
        }

        return $response;
    }

    /**
     * @param string $url
     * @param string $method
     * @param string $data|NULL
     * @return SendResponse
     */
    protected function getRequest($url, $method = 'GET', $data = NULL)
    {
        return $this->makeRequest($url, $method, $data);
    }
}
