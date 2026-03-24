<?php

use yii\helpers\Html;

/* @var $authors array */
/* @var $year int */

$this->title = 'ТОП авторов за ' . $year;
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="box box-primary">

    <div class="box-header with-border">
        <h3 class="box-title">ТОП-10 авторов за <?= Html::encode($year) ?></h3>
    </div>

    <div class="box-body">

        <form method="get" style="margin-bottom:20px;">
            <input type="number" name="year" value="<?= $year ?>"/>
            <button class="btn btn-primary">Показать</button>
        </form>
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Автор</th>
                <th>Количество книг</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($authors)): ?>
                <tr>
                    <td colspan="3">Нет данных за этот год</td>
                </tr>
            <?php else: ?>
                <?php foreach ($authors as $index => $author): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= Html::encode($author['full_name']) ?></td>
                        <td><?= $author['books_count'] ?></td>
                        <td>
                            <?= Html::a(
                                    'Подписаться',
                                    ['author/subscribe', 'authorId' => $author['id']],
                                    [
                                            'class' => 'btn btn-success',
                                            'data-method' => 'post',
                                    ]
                            ) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>