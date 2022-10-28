<?php

namespace Pes\SmsManager;

use Pes\SmsManager\SendRequest;
use PHPUnit\Framework\TestCase;

final class SendRequestTest extends TestCase
{
    public function testClassConstructor()
	{
		$request = new SendRequest('message', '123456789', SendRequest::PRIORITY_DIRECT);
		$this->assertSame(['123456789'], $request->getNumber());
		$this->assertSame('message', $request->getMessage());
		$this->assertSame(SendRequest::PRIORITY_DIRECT, $request->getGateway());
        $this->assertFalse($request->isValidPhone('telefonnicislo'));
        $this->assertTrue($request->isValidPhone('+420123456789'));
        $this->assertTrue($request->isValidPhone('00420123456789'));
        $this->assertTrue($request->isValidPhone('123456789'));
        //$this->assertNotNull($request->validate());       
	}

    /**
     * @dataProvider dataProviderConstruct
     */
    public function testConstruct(String $expectedRequestType, ?String $requestType) : void
    {
        $message    = 'Anchovy essence soup is just not the same without anise and bitter ground pickles.';
        $number = ['+420777888999'];
        $sender     = 'sender';
        $customId   = 1;
        $smsMessage = new SendRequest($message, $number, $requestType, $sender, $customId);

        self::assertSame($message, $smsMessage->getMessage());
        self::assertSame($number, $smsMessage->getNumber());
        self::assertSame($expectedRequestType, $smsMessage->getGateway());
        self::assertSame($sender, $smsMessage->getSender());
        self::assertSame($customId, $smsMessage->getCustomid());
    }

    /**
     * @return mixed[][]
     */
    public function dataProviderConstruct() : array
    {
        return [
            [SendRequest::PRIORITY_HIGH, SendRequest::PRIORITY_HIGH],
            [SendRequest::PRIORITY_LOWCOST, null],
        ];
    }

    /**
     * @dataProvider dataProviderToUrl
     */
    public function testToUrl(String $expectedUrl, ?Array $requestData) : void
    {
        $request = new SendRequest($requestData);
        self::assertSame($expectedUrl, $request->toUrl());
    }

    /**
     * @return mixed[][]
     */
    public function dataProviderToUrl() : array
    {
        return [
            ['number=420123456789&message=message&gateway=high&sender=420987654321&customid=123&time=2022-01-02T10%3A20%3A30&expiration=2023-03-04T10%3A20%3A30', 
                array('message' => 'message', 'number' => '420123456789', 'gateway' => SendRequest::PRIORITY_HIGH, 
                    'sender' => '420987654321', 'customid' => '123', 
                    'time' => '2022-01-02T10:20:30', 'expiration' => '2023-03-04T10:20:30')],
                ['number=420123456789&message=message&gateway=high&sender=420987654321&customid=123', 
                array('message' => 'message', 'number' => '420123456789', 'gateway' => SendRequest::PRIORITY_HIGH, 
                    'sender' => '420987654321', 'customid' => '123')],
                ['number=420123456789&message=message&gateway=high&sender=420987654321', 
                array('message' => 'message', 'number' => '420123456789', 'gateway' => SendRequest::PRIORITY_HIGH, 
                    'sender' => '420987654321')],
        ];
    }

}