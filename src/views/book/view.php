<?php

use yii\helpers\Html;


?>

<h1><?= Html::encode($book->title) ?></h1>

<p><b>Год:</b> <?= $book->year ?></p>
<p><b>ISBN:</b> <?= $book->isbn ?></p>
<p><b>Описание:</b><br><?= nl2br(Html::encode($book->description)) ?></p>

<p><b>Авторы:</b></p>
<?php foreach ($book->authors as $author): ?>
    <div class="author-block">
        <h4><?= $author->full_name ?></h4>
        <?= Html::a(
                'Подписаться',
                ['author/subscribe', 'authorId' => $author->id],
                [
                        'class' => 'btn btn-success',
                        'data-method' => 'post',
                ]
        ) ?>
    </div>
<?php endforeach; ?>

<p>
    <?= Html::a('Редактировать', ['update', 'id' => $book->id]) ?>
</p>