<?php

use yii\helpers\Html;
use yii\grid\GridView;
use andrewdanilov\CustomPages\common\models\Page;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel andrewdanilov\CustomPages\backend\models\PageSearch */

$this->title = 'Страницы';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="page-index">

    <p>
        <?= Html::a('Добавить страницу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
	        [
		        'attribute' => 'id',
		        'headerOptions' => ['width' => 100],
	        ],
            'title',
            'slug',
            'published_at',

	        [
		        'class' => 'andrewdanilov\gridtools\FontawesomeActionColumn',
		        'template' => '{update}{delete}',
	        ],
        ],
    ]); ?>
</div>
