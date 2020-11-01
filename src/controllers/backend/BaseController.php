<?php
namespace andrewdanilov\custompages\controllers\backend;

use yii\web\Controller;
use yii\filters\AccessControl;
use andrewdanilov\custompages\BackendModule;

class BaseController extends Controller
{
	public $access;

	public function init()
	{
		if (empty($this->access)) {
			$module = BackendModule::getInstance();
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