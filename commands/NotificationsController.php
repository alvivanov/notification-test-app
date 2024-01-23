<?php

declare(strict_types=1);

namespace app\commands;

use app\models\Notification\Notification;
use app\services\NotificationManager\NotificationManagerInterface;
use app\services\NotificationSender\Exceptions\SendingErrorException;
use app\services\NotificationSender\Exceptions\StrategyNotFoundException;
use app\services\NotificationSender\NotificationSenderInterface;
use yii\console\Controller;
use yii\console\ExitCode;

final class NotificationsController extends Controller
{
    public function actionSendPending(NotificationSenderInterface $notificationSender, NotificationManagerInterface $notificationManager): int
    {
        $this->stdout("Start sending pending notifications\n");

        /** @var Notification $notification */
        foreach (Notification::find()->pending()->each() as $notification) {
            try {
                $this->stdout("Trying to send notification with id='{$notification->id}'... ");

                $notificationSender->send($notification);
                $notificationManager->markAsSent($notification);

                $this->stdout("Success\n");
            } catch (SendingErrorException|StrategyNotFoundException $e) {
                $notificationManager->markAsFailed($notification);

                $this->stdout("Failed ({$e->getMessage()})\n");
            }
        }

        $this->stdout("Finish!\n");

        return ExitCode::OK;
    }
}
