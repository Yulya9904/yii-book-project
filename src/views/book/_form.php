<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\Author;

/* @var yii\web\View $this */
/* @var app\forms\BookForm $model */

?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <?php $form = ActiveForm::begin(); ?>
            <div class="box-body table-responsive">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'year')->textInput() ?>
                <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
                <?= $form->field($model, 'cover')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'authors')->checkboxList(
                    Author::find()
                        ->select(['full_name', 'id'])
                        ->indexBy('id')
                        ->column()
                ) ?>
            </div>
            <div class="box-footer">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>