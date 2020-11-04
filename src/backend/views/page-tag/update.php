<?php

/* @var $this yii\web\View */
/* @var $model andrewdanilov\custompages\common\models\PageTag */

$this->title = Yii::t('custompages/page-tag', 'Modify tag') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('custompages/page-tag', 'Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="page-tag-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
