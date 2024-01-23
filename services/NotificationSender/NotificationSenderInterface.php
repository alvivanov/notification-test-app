<?php

declare(strict_types=1);

namespace app\services\NotificationSender;

use app\models\Notification\Notification;
use app\services\NotificationSender\Exceptions\SendingErrorException;
use app\services\NotificationSender\Exceptions\StrategyNotFoundException;

interface NotificationSenderInterface
{
    /**
     * @throws StrategyNotFoundException
     * @throws SendingErrorException
     */
    public function send(Notification $notification): void;
}
