<?php

namespace app\forms;

use app\forms\validators\PhoneNumberValidator;
use yii\base\Model;

class AuthorSubscriptionForm extends Model
{
    public $author_id;
    public $email;
    public $phone;

    public function rules()
    {
        return [
            ['author_id', 'required'],
            ['email', 'email'],
            ['phone', 'string', 'max' => 20],
            [['email', 'phone'], 'required', 'when' => function ($model) {
                return empty($model->email) && empty($model->phone);
            }],
            ['phone', PhoneNumberValidator::class],
        ];
    }
}