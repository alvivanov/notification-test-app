<?php

declare(strict_types=1);

namespace app\services\NotificationSender;

use app\models\Notification\Notification;
use app\services\NotificationSender\Exceptions\StrategyNotFoundException;
use app\services\NotificationSender\SendingStrategies\SendingStrategyInterface;

final readonly class NotificationSender implements NotificationSenderInterface
{
    public function __construct(
        /** @var iterable<int, SendingStrategyInterface> */
        private iterable $strategies
    ) {
    }

    public function send(Notification $notification): void
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->canProcess($notification->channel)) {
                $strategy->send($notification->content);

                return;
            }
        }

        throw new StrategyNotFoundException($notification->channel);
    }
}
