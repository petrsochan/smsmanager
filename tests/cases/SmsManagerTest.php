<?php

namespace Pes\SmsManager;

use Pes\SmsManager\SmsManager;
use PHPUnit\Framework\TestCase;

final class SmsManagerTest extends TestCase
{
    public function testClassConstructor()
    {
        $client = new SmsManager('apikey');
        $this->assertSame('apikey', $client->getApikey());
    }
}
