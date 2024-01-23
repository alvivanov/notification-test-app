<?php

declare(strict_types=1);

namespace app\services\NotificationManager;

use app\models\Notification\Notification;

interface NotificationManagerInterface
{
    public function create(array $data): Notification;

    public function update(Notification $notification, array $data): void;

    public function markAsFailed(Notification $notification): void;

    public function markAsSent(Notification $notification): void;

    public function delete(Notification $notification): void;
}
