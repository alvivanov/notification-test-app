<?php

declare(strict_types=1);

namespace app\services\NotificationSender\Exceptions;

final class SendingErrorException extends \Exception
{
    public function __construct(string $errorText)
    {
        parent::__construct("Error occured during notification sending: '{$errorText}'");
    }
}
