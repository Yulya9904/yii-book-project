<?php

namespace app\repositories;

use yii\db\Query;

class AuthorRepository
{
    public function getToAuthorsByYear(int $year): array
    {
        return (new Query())
            ->select([
                'author.id',
                'author.full_name',
                'books_count' => 'COUNT(book.id)',
            ])
            ->from('author')
            ->innerJoin('author_book', 'author_book.author_id = author.id')
            ->innerJoin('book', 'book.id = author_book.book_id')
            ->where(['book.year' => $year])
            ->groupBy(['author.id', 'author.full_name'])
            ->orderBy(['books_count' => SORT_DESC])
            ->limit(10)
            ->all();
    }
}