<?php
namespace andrewdanilov\custompages;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
	/**
	 * @inheritdoc
	 */
	public function bootstrap($app)
	{
		$app->getUrlManager()->addRules([
			[
				'class' => 'andrewdanilov\custompages\components\frontend\UrlRule',
			]
		], false);
	}
}