<?php

declare(strict_types=1);

use app\models\Notification\Notification;
use app\tests\fixtures\NotificationFixture;

final class SendPendingNotificationCest
{
    public function successful(FunctionalTester $I): void
    {
        $I->runShellCommand('tests/bin/yii notifications/send-pending');
        $I->cantSeeRecord(Notification::class, ['status' => Notification::PENDING_STATUS]);
    }

    public function _fixtures(): array
    {
        return ['notification' => NotificationFixture::class];
    }
}
