<?php

use Yii;

/* @var $this yii\web\View */
/* @var $model andrewdanilov\custompages\models\Category */

$this->title = Yii::t('custompages/backend/category', 'Modify category') . ': ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('custompages/backend/category', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->title;
?>
<div class="page-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
