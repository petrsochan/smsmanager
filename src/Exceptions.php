<?php
declare(strict_types=1);

namespace PeS\SmsManager;

class InvalidNumberException extends \InvalidArgumentException
{
}

class InvalidArgumentException extends \InvalidArgumentException
{
}

class InvalidStateException extends \RuntimeException
{
}

class MemberAccessException extends \LogicException
{
}

class NotImplementedException extends \LogicException
{
}