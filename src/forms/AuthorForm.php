<?php

namespace app\forms;

use yii\base\Model;

/**
 * @property mixed $description
 * @property mixed $full_name
 */
class AuthorForm extends Model
{
    public mixed $full_name = null;
    public mixed $description = null;

    public function rules()
    {
        return [
            ['full_name', 'string', 'max' => 20],
            ['description', 'string', 'max' => 20],
            [['description', 'full_name'], 'required'],
        ];
    }
}