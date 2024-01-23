<?php

declare(strict_types=1);

namespace app\services\NotificationSender\Exceptions;

final class StrategyNotFoundException extends \Exception
{
    public function __construct(string $channel)
    {
        parent::__construct("Unable to find sending strategy for channel '{$channel}'");
    }
}
