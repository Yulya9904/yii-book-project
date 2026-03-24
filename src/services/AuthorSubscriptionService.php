<?php

declare(strict_types=1);

namespace app\services;

use app\forms\AuthorSubscriptionForm;
use app\models\AuthorSubscription;

class AuthorSubscriptionService
{
    public function subscribe(AuthorSubscriptionForm $form): bool
    {
        if (!$form->validate()) {
            return false;
        }
        $exists = AuthorSubscription::find()
            ->where([
                'author_id' => $form->author_id,
                'email' => $form->email,
                'phone' => $form->phone,
            ])
            ->exists();
        if ($exists) {
            return true;
        }
        $subscription = new AuthorSubscription();
        $subscription->author_id = $form->author_id;
        $subscription->email = $form->email;
        $subscription->phone = $form->phone;
        $subscription->created_at = date('Y-m-d H:i:s');
        return $subscription->save();
    }
}