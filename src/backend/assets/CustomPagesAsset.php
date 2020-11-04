<?php
namespace andrewdanilov\custompages\backend\assets;

use yii\web\AssetBundle;

class CustomPagesAsset extends AssetBundle
{
	public $sourcePath = '@andrewdanilov/custompages/backend/web';
	public $css = [
		'css/custom-pages.css',
	];
	public $js = [
		'js/custom-pages.js',
	];
	public $depends = [
		'yii\web\JqueryAsset',
		'andrewdanilov\gridtools\GridToolsAsset',
	];
}