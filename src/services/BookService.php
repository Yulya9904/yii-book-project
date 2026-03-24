<?php

declare(strict_types=1);

namespace app\services;

use app\forms\BookForm;
use app\models\Book;
use Yii;

class BookService
{
    public function __construct(protected NotificationService $notificationService)
    {
    }

    public function create(BookForm $form): Book
    {
        $book = new Book();
        $book->created_at = date('Y-m-d H:i:s');
        $book->updated_at = date('Y-m-d H:i:s');
        $this->fillAttributes($book, $form);
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $book->save(false);
            $this->updateAuthors($book, $form);
            $this->notificationService->notifyAboutNewBook(array_column($book->authors, 'id'), $book);
            $transaction->commit();
            return $book;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    public function update(Book $book, BookForm $form): bool
    {
        if (!$form->validate()) {
            return false;
        }
        $book->updated_at = date('Y-m-d H:i:s');
        $this->fillAttributes($book, $form);
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $book->save(false);
            $this->updateAuthors($book, $form);
            $transaction->commit();
            return true;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    private function updateAuthors(Book $book, BookForm $form): void
    {
        $oldIds = array_column($book->authors, 'id');
        $newIds = $form->authors ?: [];
        // удалить лишние
        $removeIds = array_diff($oldIds, $newIds);
        if ($removeIds) {
            Yii::$app->db->createCommand()
                ->delete('author_book', ['author_id' => $removeIds])
                ->execute();
        }
        // добавить новые
        $addIds = array_diff($newIds, $oldIds);
        if ($addIds) {
            $addIds = array_map(function ($authorId) use ($book) {
                return [$book->id, $authorId];
            }, $addIds);
            Yii::$app->db->createCommand()
                ->batchInsert('author_book', ['book_id', 'author_id'], $addIds)
                ->execute();
        }
        unset($book->authors);
    }

    private function fillAttributes(Book $book, BookForm $form): void
    {
        $book->title = $form->title;
        $book->year = $form->year;
        $book->description = $form->description;
        $book->isbn = $form->isbn;
        $book->cover = $form->cover;
    }
}