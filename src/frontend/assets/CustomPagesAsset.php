<?php
namespace andrewdanilov\custompages\frontend\assets;

use yii\web\AssetBundle;

class CustomPagesAsset extends AssetBundle
{
	public $sourcePath = '@andrewdanilov/custompages/frontend/web';
	public $css = [
		'css/custom-pages.css',
	];
	public $js = [
		'js/custom-pages.js',
	];
	public $depends = [
		'yii\web\JqueryAsset',
		'andrewdanilov\swiperslider\SwiperSliderAsset',
		'andrewdanilov\fancybox\FancyboxAsset',
	];
}