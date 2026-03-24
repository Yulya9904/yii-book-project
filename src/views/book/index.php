<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var yii\web\View $this */
/* @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Книги';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Добавить книгу', ['create'], ['class' => 'btn btn-success']) ?>
    </div>

    <div class="box-body no-padding">
        <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [

                        'id',
                        'title',
                        'year',
                        'isbn',

                        [
                                'label' => 'Авторы',
                                'value' => function ($model) {
                                    return implode(', ', array_map(
                                            fn($a) => $a->full_name,
                                            $model->authors
                                    ));
                                }
                        ],
                        [
                                'class' => yii\grid\ActionColumn::class,
                                'template' => '{view}',
                                'buttons' => [
                                        'view' => fn($url) => Html::a('Просмотр', $url, ['class' => 'btn btn-primary btn-xs']),
                                ],
                                'contentOptions' => ['style' => 'width:200px'],
                        ],
                        [
                                'class' => yii\grid\ActionColumn::class,
                                'template' => '{update} {delete}',
                                'buttons' => [
                                        'update' => fn($url) => Html::a('Ред.', $url, ['class' => 'btn btn-warning btn-xs']),
                                        'delete' => fn($url) => Html::a('Удалить', $url, [
                                                'class' => 'btn btn-danger btn-xs',
                                                'data-method' => 'post',
                                                'data-confirm' => 'Удалить книгу?',
                                        ]),
                                ],
                                'contentOptions' => ['style' => 'width:200px'],
                                'visible' => !Yii::$app->user->isGuest,
                        ],
                ],
        ]) ?>
    </div>
</div>