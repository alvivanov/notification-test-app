<?php

declare(strict_types=1);

namespace app\models\Notification;

use yii\db\ActiveRecord;

/**
 * @property int         id
 * @property string      content
 * @property string      channel
 * @property string      status
 * @property null|string sent_at
 * @property string      created_at
 *
 * @method static self findOne($condition)
 */
final class Notification extends ActiveRecord
{
    public const string SCENARIO_CREATE = 'create';
    public const string SCENARIO_UPDATE = 'update';
    public const string SCENARIO_SEND = 'send';

    public const string SMS_CHANNEL = 'sms';
    public const string TELEGRAM_CHANNEL = 'telegram';

    public const string PENDING_STATUS = 'pending';
    public const string FAILED_STATUS = 'failed';
    public const string SENT_STATUS = 'sent';

    public function scenarios(): array
    {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_CREATE => ['content', 'channel'],
            self::SCENARIO_UPDATE => ['content', 'channel'],
            self::SCENARIO_SEND => ['status', 'sent_at'],
        ]);
    }

    public static function tableName(): string
    {
        return 'notifications';
    }

    public static function find(): NotificationQuery
    {
        return new NotificationQuery(self::class);
    }

    public function rules(): array
    {
        return [
            [['content', 'channel', 'status', 'created_at'], 'required'],
            ['content', 'string', 'max' => 1_000],
            ['channel', 'string'],
            ['channel', 'in', 'range' => [self::SMS_CHANNEL, self::TELEGRAM_CHANNEL]],
            ['status', 'in', 'range' => [self::SENT_STATUS, self::FAILED_STATUS], 'on' => self::SCENARIO_SEND],
            [['sent_at', 'created_at'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'channel' => 'Channel',
            'status' => 'Status',
            'sent_at' => 'Sent At',
            'created_at' => 'Created At',
        ];
    }
}
