<?php

use yii\helpers\Html;

/* @var yii\web\View $this */
/* @var app\models\Author $model */

$this->title = $model->full_name;
$this->params['breadcrumbs'][] = ['label' => 'Авторы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-primary">
    <div class="box-body">
        <p><b>ID:</b> <?= $model->id ?></p>
        <p><b>Имя:</b> <?= Html::encode($model->full_name) ?></p>
        <p><b>Email:</b> <?= Html::encode($model->email) ?></p>
        <p><b>Книги:</b>
            <?= implode(', ', array_map(
                fn($book) => $book->title,
                $model->books
            )) ?>
        </p>
    </div>
    <div class="box-footer">
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </div>
</div>