<?php
/**
 * @package NCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 20.11.14
 */

namespace app\ncmscore\helpers\admin;

/**
 * Хелпер для генерации урлов для админки
 */
class Url extends \yii\helpers\Url {

	/**
	 * @inheritdoc
	 */
	public static function toRoute($route, $scheme = false)
	{
		$route = (array)$route;

		$modelName = \Yii::$app->controller->modelName;
		if (!array_key_exists('model', $route) and !empty($modelName)) {
			$route['model'] = $modelName;
		}

		return parent::toRoute($route, $scheme);
	}
}