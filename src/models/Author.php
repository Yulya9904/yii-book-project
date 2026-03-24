<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class Author
 *
 * @property int    $id
 * @property string $full_name
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Book[] $books
 */
class Author extends ActiveRecord
{
    public static function tableName()
    {
        return 'author';
    }

    public function getBooks()
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])
            ->viaTable('author_book', ['author_id' => 'id']);
    }
}
