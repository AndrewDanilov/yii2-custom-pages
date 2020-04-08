<?php

use Yii;

/* @var $this yii\web\View */
/* @var $model andrewdanilov\custompages\models\Page */

$this->title = Yii::t('custompages/backend/page', 'Add page');
$this->params['breadcrumbs'][] = ['label' => Yii::t('custompages/backend/page', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
