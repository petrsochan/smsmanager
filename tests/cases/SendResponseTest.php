<?php

namespace Pes\SmsManager;

use Pes\SmsManager\SendResponse;
use PHPUnit\Framework\TestCase;

final class SendResponseTest extends TestCase
{
    /**
     * @dataProvider dataProviderConstruct
     */
    public function testConstruct($exp, ?String $responseString) : void
    {
        $response = new SendResponse($responseString);

        self::assertSame($exp['result'], $response->getResult());
        self::assertSame($exp['requestid'], $response->getRequestid());
        self::assertSame($exp['phone'], $response->getPhone());
        self::assertSame($exp['customid'], $response->getCustomid());
        self::assertSame($exp['errorid'], $response->getErrorid());
    }

    /**
     * @return mixed[][]
     */
    public function dataProviderConstruct() : array
    {
        return [
            [array('result' => 'OK', 'requestid' => '12345', 'phone' => ['420777111222'], 'customid' => null, 'errorid' => null), "OK|12345|420777111222"],
            [array('result' => 'OK', 'requestid' => '12345', 'phone' => ['420777111222'], 'customid' => '99999', 'errorid' => null), "OK|12345|420777111222|99999"],
            [array('result' => 'OK', 'requestid' => '12345', 'phone' => ['420777111222','420777111333','420777111444'], 'errorid' => null, 'customid' => '99999'), "OK|12345|420777111222,420777111333,420777111444|99999"],
            [array('result' => 'ERR', 'errorid' => '102', 'requestid' => null, 'phone' => [], 'customid' => null), "ERR|102"],
        ];
    }
}