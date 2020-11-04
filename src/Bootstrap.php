<?php
namespace andrewdanilov\custompages;

use Yii;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
	public $appFrontendId = 'app-frontend';

	/**
	 * @inheritdoc
	 */
	public function bootstrap($app)
	{
		if (Yii::$app->id === $this->appFrontendId) {
			$app->getUrlManager()->addRules([
				[
					'class' => 'andrewdanilov\custompages\frontend\components\UrlRule',
				]
			], false);
		}
	}
}