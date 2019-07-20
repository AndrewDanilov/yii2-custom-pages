<?php
namespace andrewdanilov\CustomPages;

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
				'andrewdanilov\CustomPages\components\UrlRule',
			]
		);
	}
}