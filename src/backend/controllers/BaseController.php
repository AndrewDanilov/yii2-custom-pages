<?php
namespace andrewdanilov\custompages\backend\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use andrewdanilov\custompages\backend\Module;

class BaseController extends Controller
{
	public $access;

	public function init()
	{
		if (empty($this->access)) {
			$module = Module::getInstance();
			if (isset($module->access)) {
				$this->access = $module->access;
			} else {
				$this->access = ['@'];
			}
		}
		parent::init();
	}

	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::class,
				'rules' => [
					[
						'allow' => true,
						'roles' => $this->access,
					],
				],
			],
		];
	}
}