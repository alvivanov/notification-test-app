<?php

declare(strict_types=1);

use app\models\Notification\Notification;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Examples;
use Codeception\Example;
use app\tests\fixtures\NotificationFixture;

class UpdateNotificationCest
{
    #[Examples(['content' => 'new new new'])]
    #[Examples(['channel' => Notification::SMS_CHANNEL])]
    #[Examples(['content' => 'new new new', 'channel' => Notification::TELEGRAM_CHANNEL])]
    public function successful(FunctionalTester $I, Example $example): void
    {
        /** @var Notification $notification */
        $notification = $I->grabRecord(Notification::class, ['status' => Notification::PENDING_STATUS]);

        $I->sendPut('/notifications/' . $notification->id, iterator_to_array($example->getIterator()));
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'status_code' => 200,
            'message' => 'Notification updated',
        ]);
        $I->canSeeRecord(Notification::class, [
            'id' => $notification->id,
            'content' => $example['content'] ?? $notification->content,
            'channel' => $example['channel'] ?? $notification->channel,
            'status' => $notification->status,
            'sent_at' => $notification->sent_at,
            'created_at' => $notification->created_at,
        ]);
    }

    #[Examples(invalidStatus: Notification::SENT_STATUS)]
    #[Examples(invalidStatus: Notification::FAILED_STATUS)]
    public function invalidStatusException(FunctionalTester $I, Example $example): void
    {
        /** @var Notification $notification */
        $notification = $I->grabRecord(Notification::class, ['status' => $example['invalidStatus']]);

        $I->sendPut('/notifications/' . $notification->id, [
            'content' => 'new content',
            'channel' => Notification::SMS_CHANNEL,
        ]);
        $I->seeResponseCodeIs(400);
        $I->seeResponseContainsJson([
            'status_code' => 400,
            'message' => 'Notification can be updated only in "pending" status',
        ]);
        $I->canSeeRecord(Notification::class, $notification->getAttributes());
    }

    public function notFoundException(FunctionalTester $I): void
    {
        $I->sendPut('/notifications/1000000');
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

    #[DataProvider('invalidDataProvider')]
    public function validationFailed(FunctionalTester $I, Example $example): void
    {
        /** @var Notification $notification */
        $notification = $I->grabRecord(Notification::class, ['status' => Notification::PENDING_STATUS]);

        $I->sendPut('/notifications/' . $notification->id, $example['data']);
        $I->seeResponseCodeIs(422);
        $I->seeResponseContainsJson([
            'status_code' => 422,
            'message' => 'Validation failed',
            'errors' => $example['errors'],
        ]);
    }

    private function invalidDataProvider(): array
    {
        return [
            'too long params request' => [
                'data' => [
                    'content' => str_repeat('A', 1_001),
                ],
                'errors' => [
                    'content' => ['Content should contain at most 1,000 characters.'],
                ],
            ],
            'params with invalid type request' => [
                'data' => [
                    'channel' => 1,
                ],
                'errors' => [
                    'channel' => ['Channel is invalid.'],
                ],
            ],
        ];
    }
}
