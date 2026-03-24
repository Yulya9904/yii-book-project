<?php

use yii\db\Migration;

/**
 * Handles the creation of table `book`.
 */
class m260321_134458_create_book_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('book', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'year' => $this->integer(),
            'description' => $this->text(),
            'isbn' => $this->string()->unique(),
            'cover' => $this->string(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
        ]);

        // Связующая таблица книги-авторы
        $this->createTable('author_book', [
            'book_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_author_book_book_id',
            'author_book',
            'book_id',
            'book',
            'id',
            'RESTRICT',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_author_book_author_id',
            'author_book',
            'author_id',
            'author',
            'id',
            'RESTRICT',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('author_book');
        $this->dropTable('book');
    }
}
