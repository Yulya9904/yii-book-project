<?php

use yii\db\Migration;

/**
 * Handles the creation of table `author_subscription`.
 */
class m260322_120036_create_author_subscription_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('author_subscription', [
            'id' => $this->primaryKey(),
            'phone' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_author_subscription_book',
            'author_subscription',
            'author_id',
            'author',
            'id',
            'RESTRICT',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('author_subscription');
    }
}
