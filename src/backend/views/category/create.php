<?php

/* @var $this yii\web\View */
/* @var $model andrewdanilov\custompages\common\models\Category */

$this->title = Yii::t('custompages/category', 'Add category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('custompages/category', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
