<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class Book
 *
 * @property int         $id
 * @property string      $title
 * @property int|null    $year
 * @property string|null $description
 * @property string|null $isbn
 * @property string|null $cover
 * @property int|null    $created_at
 * @property int|null    $updated_at
 *
 * @property Author[]    $authors
 */
class Book extends ActiveRecord
{
    public static function tableName()
    {
        return 'book';
    }

    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->viaTable('author_book', ['book_id' => 'id']);
    }
}