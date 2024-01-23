<?php

declare(strict_types=1);

use app\models\Notification\Notification;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Examples;
use Codeception\Example;
use yii\test\InitDbFixture;

final class CreateNotificationCest
{
    #[Examples(Notification::TELEGRAM_CHANNEL)]
    #[Examples(Notification::SMS_CHANNEL)]
    public function successful(FunctionalTester $I, Example $example): void
    {
        $I->sendPost('/notifications', [
            'content' => 'test content',
            'channel' => $example[0],
        ]);
        $I->seeResponseCodeIs(201);
        $I->seeResponseContainsJson([
            'status_code' => 201,
            'message' => 'Notification created',
        ]);

        $I->canSeeRecord(Notification::class, [
            'content' => 'test content',
            'channel' => $example[0],
            'status' => Notification::PENDING_STATUS,
            'sent_at' => null,
        ]);
    }

    public function _fixtures(): array
    {
        return ['init' => InitDbFixture::class];
    }

    #[DataProvider('invalidDataProvider')]
    public function validationFailed(FunctionalTester $I, Example $example): void
    {
        $t = $I->sendPost('/notifications', $example['data']);
        $I->seeResponseCodeIs(422);
        $I->seeResponseContainsJson([
            'status_code' => 422,
            'message' => 'Validation failed',
            'errors' => $example['errors'],
        ]);
        $I->assertEquals(0, Notification::find()->count());
    }

    private function invalidDataProvider(): array
    {
        return [
            'empty request' => [
                'data' => [],
                'errors' => [
                    'content' => ['Content cannot be blank.'],
                    'channel' => ['Channel cannot be blank.'],
                ],
            ],
            'empty string params request' => [
                'data' => [
                    'content' => '',
                    'channel' => '',
                ],
                'errors' => [
                    'content' => ['Content cannot be blank.'],
                    'channel' => ['Channel cannot be blank.'],
                ],
            ],
            'null params request' => [
                'data' => [
                    'content' => null,
                    'channel' => null,
                ],
                'errors' => [
                    'content' => ['Content cannot be blank.'],
                    'channel' => ['Channel cannot be blank.'],
                ],
            ],
            'too long params request' => [
                'data' => [
                    'content' => str_repeat('A', 1_001),
                    'channel' => Notification::SMS_CHANNEL,
                ],
                'errors' => [
                    'content' => ['Content should contain at most 1,000 characters.'],
                ],
            ],
            'params with invalid type request' => [
                'data' => [
                    'content' => 1,
                    'channel' => 1,
                ],
                'errors' => [
                    'channel' => ['Channel is invalid.'],
                ],
            ],
        ];
    }
}
