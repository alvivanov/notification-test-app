<?php

declare(strict_types=1);

use app\models\Notification\Notification;
use app\tests\fixtures\NotificationFixture;

final class GetAllNotificationsCest
{
    public function successful(FunctionalTester $I): void
    {
        $I->sendGet('/notifications');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'status_code' => 200,
            'message' => 'Success',
            'data' => array_map(
                static fn (Notification $notification): array => $notification->getAttributes(),
                Notification::find()->all()
            ),
        ]);
    }

    public function _fixtures(): array
    {
        return ['notification' => NotificationFixture::class];
    }
}
