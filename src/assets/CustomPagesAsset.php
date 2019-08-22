<?php
namespace andrewdanilov\custompages;

use yii\web\AssetBundle;

class CustomPagesAsset extends AssetBundle
{
	public $sourcePath = '@andrewdanilov/custompages/web';
	public $css = [
	];
	public $js = [
		'js/custom-pages.js'
	];
	public $depends = [
		'yii\web\JqueryAsset',
		'andrewdanilov\swiperslider\SwiperSliderAsset',
		'andrewdanilov\fancybox\FancyboxAsset',
	];
}