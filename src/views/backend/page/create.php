<?php

/* @var $this yii\web\View */
/* @var $model andrewdanilov\custompages\models\Page */

$this->title = 'Add page';
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
