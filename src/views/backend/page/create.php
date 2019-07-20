<?php

/* @var $this yii\web\View */
/* @var $model andrewdanilov\common\models\Page */

$this->title = 'Добавить страницу';
$this->params['breadcrumbs'][] = ['label' => 'Страницы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
