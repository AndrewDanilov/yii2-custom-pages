<?php

/* @var $this yii\web\View */
/* @var $model andrewdanilov\custompages\common\models\Page */

$this->title = Yii::t('custompages/page', 'Modify page') . ': ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('custompages/page', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->title;
?>
<div class="page-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
