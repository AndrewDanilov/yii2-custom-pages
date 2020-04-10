<?php

use Yii;

/* @var $this yii\web\View */
/* @var $model andrewdanilov\custompages\models\PageTag */

$this->title = Yii::t('custompages/backend/page-tag', 'Add tag');
$this->params['breadcrumbs'][] = ['label' => Yii::t('custompages/backend/page-tag', 'Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-tag-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
