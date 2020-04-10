<?php

use Yii;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel andrewdanilov\custompages\models\backend\PageTagSearch */

$this->title = Yii::t('custompages/backend/page-tag', 'Tags');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-tag-index">

    <p>
        <?= Html::a(Yii::t('custompages/backend/page-tag', 'Add tag'), ['page-tag/create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
	        [
		        'attribute' => 'id',
		        'headerOptions' => ['width' => 100],
	        ],
            'name',
            'slug',

	        [
		        'class' => 'andrewdanilov\gridtools\FontawesomeActionColumn',
		        'template' => '{update}{delete}',
	        ],
        ],
    ]); ?>
</div>
