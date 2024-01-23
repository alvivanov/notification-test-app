<?php

declare(strict_types=1);

namespace app\services\NotificationSender\SendingStrategies;

use app\models\Notification\Notification;
use app\services\NotificationSender\Exceptions\SendingErrorException;

final class SmsSendingStrategy implements SendingStrategyInterface
{
    public function send(string $text): void
    {
        if (1 === random_int(0, 1)) {
            throw new SendingErrorException('Random error');
        }
    }

    public function canProcess(string $channel): bool
    {
        return Notification::SMS_CHANNEL === $channel;
    }
}
