<?php

declare(strict_types=1);

namespace app\services\NotificationManager;

use app\components\exceptions\ModelValidationException;
use app\models\Notification\Notification;

final readonly class NotificationManager implements NotificationManagerInterface
{
    public function create(array $data): Notification
    {
        $notification = new Notification(['scenario' => Notification::SCENARIO_CREATE]);
        $notification->status = Notification::PENDING_STATUS;
        $notification->channel = $data['channel'] ?? null;
        $notification->content = $data['content'] ?? null;
        $notification->created_at = (new \DateTime())->format('Y-m-d H:i:s');

        if (!$notification->save()) {
            throw new ModelValidationException($notification->getErrors());
        }

        return $notification;
    }

    public function update(Notification $notification, array $data): void
    {
        $notification->setScenario(Notification::SCENARIO_UPDATE);

        if ($notification->status !== $notification::PENDING_STATUS) {
            throw new \DomainException('Notification can be updated only in "pending" status');
        }

        if ($channel = $data['channel'] ?? null) {
            $notification->channel = $channel;
        }

        if ($content = $data['content'] ?? null) {
            $notification->content = $content;
        }

        if (!$notification->save()) {
            throw new ModelValidationException($notification->getErrors());
        }
    }

    public function markAsFailed(Notification $notification): void
    {
        $notification->setScenario(Notification::SCENARIO_SEND);
        $notification->sent_at = (new \DateTime())->format('Y-m-d H:i:s');
        $notification->status = Notification::FAILED_STATUS;

        if (!$notification->save()) {
            throw new ModelValidationException($notification->getErrors());
        }
    }

    public function markAsSent(Notification $notification): void
    {
        $notification->setScenario(Notification::SCENARIO_SEND);
        $notification->sent_at = (new \DateTime())->format('Y-m-d H:i:s');
        $notification->status = Notification::SENT_STATUS;

        if (!$notification->save()) {
            throw new ModelValidationException($notification->getErrors());
        }
    }

    public function delete(Notification $notification): void
    {
        $notification->delete();
    }
}
