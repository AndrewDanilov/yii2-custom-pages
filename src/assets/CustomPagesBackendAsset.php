<?php
namespace andrewdanilov\custompages;

use yii\web\AssetBundle;

class CustomPagesBackendAsset extends AssetBundle
{
	public $sourcePath = '@andrewdanilov/custompages/web';
	public $css = [
		'css/custom-pages-backend.css'
	];
	public $js = [
		'js/custom-pages-backend.js'
	];
	public $depends = [
		'yii\web\JqueryAsset',
	];
}