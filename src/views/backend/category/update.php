<?php

/* @var $this yii\web\View */
/* @var $model andrewdanilov\custompages\models\Category */

$this->title = 'Изменить категорию: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->title;
?>
<div class="page-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
