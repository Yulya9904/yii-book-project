<?php

use yii\db\Migration;

/**
 * Handles the creation of table `author`.
 */
class m260321_113145_create_author_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('author', [
            'id' => $this->primaryKey(),
            'full_name' => $this->string()->notNull(),
            'description' => $this->string()->notNull(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('author');
    }
}
