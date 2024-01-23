<?php

declare(strict_types=1);

use app\models\Notification\Notification;
use app\tests\fixtures\NotificationFixture;

final class GetNotificationCest
{
    public function successful(FunctionalTester $I): void
    {
        /** @var Notification $notification */
        $notification = $I->grabRecord(Notification::class, ['id' => 1]);

        $I->sendGet('/notifications/' . $notification->id);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'status_code' => 200,
            'message' => 'Success',
            'data' => $notification->getAttributes(),
        ]);
    }

    public function notFound(FunctionalTester $I): void
    {
        $I->sendGet('/notifications/1000000');
        $I->seeResponseCodeIs(404);
        $I->seeResponseContainsJson([
            'status_code' => 404,
            'message' => 'Notification not found',
        ]);
        $I->cantSeeRecord(Notification::class, ['id' => 1_000_000]);
    }

    public function _fixtures(): array
    {
        return ['notification' => NotificationFixture::class];
    }
}
