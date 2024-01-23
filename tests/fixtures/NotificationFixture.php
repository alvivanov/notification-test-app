<?php

declare(strict_types=1);

namespace app\tests\fixtures;

use app\models\Notification\Notification;
use yii\test\ActiveFixture;

final class NotificationFixture extends ActiveFixture
{
    public $modelClass = Notification::class;

    protected function getData(): iterable
    {
        $now = (new \DateTime())->format('Y-m-d H:i:s');
        $getData = static fn (string $status): array => [
            'status' => $status,
            'channel' => [Notification::TELEGRAM_CHANNEL, Notification::SMS_CHANNEL][random_int(0, 1)],
            'content' => 'content',
            'sent_at' => Notification::PENDING_STATUS !== $status ? $now : null,
            'created_at' => $now,
        ];

        foreach (range(1, 5) as $i) {
            yield $getData(Notification::PENDING_STATUS);
        }

        foreach (range(1, 5) as $i) {
            yield $getData(Notification::SENT_STATUS);
        }

        foreach (range(1, 5) as $i) {
            yield $getData(Notification::FAILED_STATUS);
        }
    }
}
