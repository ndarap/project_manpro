<?php

use yii\db\Migration;

class m251215_012033_add_is_read_to_notification extends Migration
{
    public function safeUp()
    {
        $this->addColumn(
            'notification',
            'is_read',
            $this->integer()->defaultValue(0)
        );
    }

    public function safeDown()
    {
        $this->dropColumn('notification', 'is_read');
    }
}
