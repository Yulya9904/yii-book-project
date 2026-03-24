<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class Book
 *
 * @property int    $id
 * @property string $phone
 * @property string $email
 * @property int    $author_id
 * @property string $created_at
 *
 * @property Author $author
 */
class AuthorSubscription extends ActiveRecord
{
    public static function tableName()
    {
        return 'author_subscription';
    }

    public function getAuthor()
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }
}