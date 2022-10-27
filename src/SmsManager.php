<?php

namespace PeS\SmsManager;

class SmsManager
{
	/** @var string */
	private $apikey;

	/** @var string */
	private $defaultSender;

	const API_URL = 'https://http-api.smsmanager.cz';
	const USER_AGENT = 'SmsManager PHP';
	const ACTION_SEND = 'Send';

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

	/**
	 * @param SendRequest|String $request
	 * @return SendResponse $response
	 */
	public function send($request, $number = null, $gateway = null, 
		$sender = null, $customid = null, $time = null, $expiration = null)
	{
		if (!($request instanceof SendRequest)) {
			$request = new SendRequest($request, $number, $gateway, $sender, $customid, $time, $expiration);
		}
		$url = self::API_URL . '/' . self::ACTION_SEND . '?apikey=' . $this->apikey . '&' . $request->toUrl();
		return new SendResponse($this->getRequest($url));
	}

	/**
	 * @param string $url
	 * @param string $method
	 * @param string $data|NULL
	 * @return mixed
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
		$response = $this->makeRequest($url, $method, $data);
		return new SendResponse($response);
	}
}
