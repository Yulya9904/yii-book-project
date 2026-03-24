<?php

namespace app\services;

namespace app\services;

use app\jobs\SendSmsJob;
use app\models\AuthorSubscription;
use app\models\Book;
use Yii;

class NotificationService
{
    public function __construct(protected SmsService $smsService)
    {
    }

    /**
     * @param int[] $authorIds
     * @param Book  $book
     * @return void
     */
    public function notifyAboutNewBook(array $authorIds, Book $book): void
    {
        $subscriptions = AuthorSubscription::find()
            ->where(['author_id' => $authorIds])
            ->all();
        foreach ($subscriptions as $sub) {
            if ($sub->phone) {
                //$this->smsService->send(
                //    $sub->phone,
                //    "Добавлена новая книга: {$book->title}"
                //);
                //@todo настроить очередь
                Yii::$app->queue->push(new SendSmsJob([
                    'phone' => $sub->phone,
                    'message' => "Добавлена новая книга: {$book->title}",
                ]));
            }
            if ($sub->email) {
                // можно добавить mail позже
            }
        }
    }
}