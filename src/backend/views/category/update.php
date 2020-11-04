<?php

/* @var $this yii\web\View */
/* @var $model andrewdanilov\custompages\common\models\Category */

$this->title = Yii::t('custompages/category', 'Modify category') . ': ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('custompages/category', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->title;
?>
<div class="page-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
