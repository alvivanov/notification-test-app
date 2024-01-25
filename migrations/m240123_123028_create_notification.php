<?php

declare(strict_types=1);

use yii\db\Migration;

final class m240123_123028_create_notification extends Migration
{
    public function up(): void
    {
        $this->createTable('notification', [
            'id' => $this->primaryKey(),
            'content' => $this->string(1_000)->notNull(),
            'channel' => $this->string(50)->notNull(),
            'status' => $this->string(50)->notNull(),
            'sent_at' => $this->dateTime(),
            'created_at' => $this->dateTime()->notNull(),
        ]);
    }

    public function down(): void
    {
        $this->dropTable('notification');
    }
}
