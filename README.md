# Smsmanager
Send and receive SMS with PHP

## Installation

via composer:

    $ composer require petrsochan/smsmanager

## Usage

### Send SMS

```php
use \PeS\SmsManager\SmsManager;
$smsConnect = new SmsManager('<apikey>');
$smsConnect->send('<text_sms>', '<phone_number>', '<gateway>', '<sender>');
```
