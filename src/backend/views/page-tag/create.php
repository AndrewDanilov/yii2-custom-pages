<?php

/* @var $this yii\web\View */
/* @var $model andrewdanilov\custompages\common\models\PageTag */

$this->title = Yii::t('custompages/page-tag', 'Add tag');
$this->params['breadcrumbs'][] = ['label' => Yii::t('custompages/page-tag', 'Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-tag-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
