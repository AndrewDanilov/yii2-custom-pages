<?php

/* @var $this yii\web\View */
/* @var $model andrewdanilov\custompages\common\models\Page */

$this->title = Yii::t('custompages/page', 'Add page');
$this->params['breadcrumbs'][] = ['label' => Yii::t('custompages/page', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
