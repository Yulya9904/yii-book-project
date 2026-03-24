<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var yii\web\View $this */
/* @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Авторы';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Добавить автора', ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="box-body no-padding">
        <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                        'id',
                        'full_name',
                        'description',
                        [
                                'label' => 'Книги',
                                'value' => function ($model) {
                                    return implode(', ', array_map(
                                            fn($book) => $book->title,
                                            $model->books
                                    ));
                                }
                        ],
                        [
                                'class' => yii\grid\ActionColumn::class,
                                'template' => '{view} {update} {delete}',
                                'buttons' => [
                                        'view' => fn($url) => Html::a('Просмотр', $url, ['class' => 'btn btn-primary btn-xs']),
                                        'update' => fn($url) => Html::a('Ред.', $url, ['class' => 'btn btn-warning btn-xs']),
                                        'delete' => fn($url) => Html::a('Удалить', $url, [
                                                'class' => 'btn btn-danger btn-xs',
                                                'data-method' => 'post',
                                                'data-confirm' => 'Удалить автора?',
                                        ]),
                                ],
                                'contentOptions' => ['style' => 'width:200px'],
                        ],
                ],
        ]) ?>
    </div>
</div>