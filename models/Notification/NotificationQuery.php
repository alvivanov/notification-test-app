<?php

declare(strict_types=1);

namespace app\models\Notification;

use yii\db\ActiveQuery;

final class NotificationQuery extends ActiveQuery
{
    public function pending(): self
    {
        return $this->andWhere(['status' => Notification::PENDING_STATUS]);
    }
}
