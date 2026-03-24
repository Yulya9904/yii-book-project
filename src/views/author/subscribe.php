<?php

/* @var app\forms\AuthorSubscriptionForm $model */

$form = \yii\widgets\ActiveForm::begin(); ?>

<?= $form->field($model, 'email') ?>
<?= $form->field($model, 'phone') ?>
<?= $form->field($model, 'author_id', ['options' => ['style' => 'display:none']]) ?>

    <button class="btn btn-success">Подписаться</button>

<?php \yii\widgets\ActiveForm::end(); ?>