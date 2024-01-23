<?php

declare(strict_types=1);

use app\models\Notification\Notification;
use app\tests\fixtures\NotificationFixture;

final class DeleteNotificationCest
{
    public function successful(FunctionalTester $I): void
    {
        $I->sendDelete('/notifications/1');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'status_code' => 200,
            'message' => 'Notification deleted',
        ]);
        $I->cantSeeRecord(Notification::class, ['id' => 1]);
    }

    public function notFoundException(FunctionalTester $I): void
    {
        $I->sendDelete('/notifications/1000000');
        $I->seeResponseCodeIs(404);
        $I->seeResponseContainsJson([
            'status_code' => 404,
            'message' => 'Notification not found',
        ]);
    }

    public function _fixtures(): array
    {
        return ['notification' => NotificationFixture::class];
    }
}
