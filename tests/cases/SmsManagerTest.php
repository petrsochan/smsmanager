<?php

namespace PeS\SmsManager;

use PeS\SmsManager\SmsManager;
use PHPUnit\Framework\TestCase;

final class SmsManagerTest extends TestCase
{
    public function testClassConstructor()
	{
		$client = new SmsManager('apikey');
		$this->assertSame('apikey', $client->getApikey());
	}
}