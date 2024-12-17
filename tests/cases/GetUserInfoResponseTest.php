<?php

namespace Pes\SmsManager;

use Pes\SmsManager\GetUserInfoResponse;
use PHPUnit\Framework\TestCase;

final class GetUserInfoResponseTest extends TestCase
{
    /**
     * @dataProvider dataProviderConstruct
     */
    public function testConstruct($exp, ?String $responseString): void
    {
        $response = new GetUserInfoResponse($responseString);

        self::assertSame($exp['credit'], $response->getCredit());
        self::assertSame($exp['sender'], $response->getSender());
        self::assertSame($exp['gateway'], $response->getGateway());
    }

    /**
     * @return mixed[][]
     */
    public function dataProviderConstruct(): array
    {
        return [
            [array('credit' => '999', 'sender' => '123456789', 'gateway' => SendRequest::PRIORITY_ECONOMY), "999|123456789|" . SendRequest::PRIORITY_ECONOMY . "\n"],
            [array('credit' => '1', 'sender' => '123456789', 'gateway' => SendRequest::PRIORITY_ECONOMY), "1|123456789|" . SendRequest::PRIORITY_ECONOMY],
        ];
    }
}
