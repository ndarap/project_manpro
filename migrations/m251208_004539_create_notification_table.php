<?php

use yii\db\Migration;

class m251208_004539_create_notification_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('notification', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'message' => $this->text()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk_notification_user',
            'notification',
            'user_id',
            'users', // <-- gunakan "users" sesuai tabel kamu
            'user_id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('notification');
    }
}
