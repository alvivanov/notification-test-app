<?php

use app\services\NotificationManager\NotificationManager;
use app\services\NotificationSender\NotificationSender;
use app\services\NotificationSender\NotificationSenderInterface;
use app\services\NotificationSender\SendingStrategies\SmsSendingStrategy;
use app\services\NotificationSender\SendingStrategies\TelegramSendingStrategy;
use app\services\NotificationManager\NotificationManagerInterface;
use yii\di\Container;

return [
    NotificationManagerInterface::class => NotificationManager::class,
    NotificationSenderInterface::class  => static function (Container $container): NotificationSenderInterface {
        return new NotificationSender([
            $container->get(SmsSendingStrategy::class),
            $container->get(TelegramSendingStrategy::class),
        ]);
    },
];