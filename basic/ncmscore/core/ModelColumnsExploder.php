<?php
/**
 * @package NCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 24.11.14
 */

namespace app\ncmscore\core;

use app\ncmscore\models\ActiveModel;
use yii\base\Component;
use yii\db\ActiveQuery;
use yii\helpers\BaseInflector;

/**
 * Компонент для извлечения колонок (атриббутов) модели и определения их типов
 */
class ModelColumnsExploder extends Component {

	/**
	 * Возвращает массив атрибутов, их типов и лейблов
	 * [
	 *  'attr1' => [
	 *      'type' => ...
	 *      'label' => ...
	 *     ]
	 * ]
	 * Ключи элементов массива: type, label
	 * 
	 * Нестандартные значения type: relation
	 * 
	 * @param ActiveModel $model
	 * @return array
	 */
	public static function getAttributes(ActiveModel $model)
	{
		$result = [];
		$fieldTypes = $model->fieldTypes;
		
		foreach ($model->attributes as $attr => $value) {
//			TODO: Перенести сюда проверку отображения поля

			$item = ['type' => 'html'];
			$camelAttr = self::camelAttribute($attr);
			$camelMethod = self::getterAttributeMethodName($attr);

			if (method_exists($model, $camelMethod) and $model->$camelMethod() instanceof ActiveQuery) {
				$item['type'] = 'relation';
				$item['label'] = BaseInflector::titleize($camelAttr);
			}
			elseif (array_key_exists($attr, $fieldTypes)) {
				$item['type'] = $fieldTypes[$attr];
			}
			
			$result[$attr] = $item;
		}
		
		return $result;
	}

	/**
	 * Возвращает массив атрибутов в формате, готовом для использования в виджете представления данных
	 * @param ActiveModel $model
	 * @return array
	 */
	public static function getViewAttributes(ActiveModel $model)
	{
		$result = [];

		$attributes = self::getAttributes($model);
		foreach ($attributes as $attr => $item) {
			switch ($item['type']) {
				case 'relation':
					$type = 'html';
//					TODO: Добавить проверку существования .caption
					$attr = lcfirst(BaseInflector::camelize($attr)) . '.caption';
					break;
				
				case 'longhtml':
					$type = 'html';
					break;
				
				default:
					$type = $item['type'];
			}

			$result[] = $attr . ':' . $type . (isset($item['label']) ? ':' . $item['label'] : '');
		}
		
		
		return $result;
	}

	/**
	 * Возвращает CamelCase свойства
	 * @param string $attr
	 * @return string
	 */
	public static function camelAttribute($attr)
	{
		return BaseInflector::camelize($attr);
	}

	/**
	 * Возвращает название гетера для свойства
	 * @param string $attr
	 * @return string
	 */
	public static function getterAttributeMethodName($attr)
	{
		return 'get' . self::camelAttribute($attr);
	}
}