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
		$app->urlManager->addRules(
			[
				'andrewdanilov\custompages\components\UrlRule',
			]
		);
	}
}