<?php

namespace app\forms;

use App\domains\country\models\Country;
use app\models\Book;
use yii\base\Model;
use yii\db\Query;

/**
 * @property mixed $title
 * @property mixed $year
 * @property mixed $description
 * @property mixed $isbn
 * @property mixed $cover
 * @property mixed $authors
 */
class BookForm extends Model
{
    public int|null $id = null;
    public mixed $title = null;
    public mixed $year = null;
    public mixed $description = null;
    public mixed $isbn = null;
    public mixed $cover = null;

    /** @var int[] */
    public mixed $authors = [];

    public function rules(): array
    {
        return [
            ['title', 'required'],
            ['year', 'integer', 'min' => 0, 'max' => date('Y')],
            ['description', 'string'],
            [['title', 'isbn', 'cover'], 'string', 'max' => 255],
            ['isbn', 'match', 'pattern' => '/^[0-9\-]+$/'],
            [
                'isbn',
                'unique',
                'targetClass' => Book::class,
                'targetAttribute' => 'isbn',
                'filter' => function (Query $query) {
                    if (isset($this->id)) {
                        $query->andWhere(['<>', 'id', $this->id]);
                    }
                },
            ],
            ['authors', 'each', 'rule' => ['integer']],
            ['authors', 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Название',
            'year' => 'Год',
            'description' => 'Описание',
            'isbn' => 'ISBN',
            'cover' => 'Фото',
        ];
    }
}