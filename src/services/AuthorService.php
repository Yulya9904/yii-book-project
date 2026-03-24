<?php

declare(strict_types=1);

namespace app\services;

use app\forms\AuthorForm;
use app\models\Author;

class AuthorService
{
    public function create(AuthorForm $form): Author
    {
        $author = new Author();
        $author->created_at = date('Y-m-d H:i:s');
        $author->updated_at = date('Y-m-d H:i:s');
        $this->fillAttributes($author, $form);
        !$author->save(false);
        return $author;
    }

    public function update(Author $author, AuthorForm $form): bool
    {
        if (!$form->validate()) {
            return false;
        }
        $author->updated_at = date('Y-m-d H:i:s');
        $this->fillAttributes($author, $form);
        !$author->save(false);
        return true;
    }

    private function fillAttributes(Author $author, AuthorForm $form): void
    {
        $author->full_name = $form->full_name;
        $author->description = $form->description;
    }
}