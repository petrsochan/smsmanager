# Smsmanager
Odesílání SMS přes PHP

## Instalace

přes composer:

    $ composer require petrsochan/smsmanager

## Použití

### Odeslání SMS

```php
use \Pes\SmsManager\SmsManager;
$smsConnect = new SmsManager('<apikey>');
$smsConnect->send('<text_sms>', '<phone_number>', '<gateway>', '<sender>');
```

### Zjištění zbývajícího kreditu a výchozího nastavení

```php
use \Pes\SmsManager\SmsManager;
$smsConnect = new SmsManager('<apikey>');
$response = $smsConnect->getUserInfo();

$credit = $response->getCredit();
$defaultSender = $response->getDefaultSender();
$defaultGateway = $response->getDefaultGateway();
```
