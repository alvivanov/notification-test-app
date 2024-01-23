<?php

declare(strict_types=1);

namespace app\services\NotificationSender\SendingStrategies;

use app\services\NotificationSender\Exceptions\SendingErrorException;

interface SendingStrategyInterface
{
    /**
     * @throws SendingErrorException
     */
    public function send(string $text): void;

    public function canProcess(string $channel): bool;
}
