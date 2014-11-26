<?php
/**
 * @package NCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 17.11.14
 */

namespace app\ncmscore\widgets;

use app\ncmscore\models\ActiveModel;
use yii\grid\ActionColumn;
use app\ncmscore\core\ModelColumnsExploder;

/**
 * Адаптированный GridView
 */
class GridView extends \yii\grid\GridView {
	
	/**
	 * @inheritdoc
	 */
	protected function guessColumns()
	{
		$models = $this->dataProvider->getModels();
		$model = reset($models);
		
		if ($model instanceof ActiveModel) {
			$this->columns = ModelColumnsExploder::getViewAttributes($model);
			
		} else {
			parent::guessColumns();
		}
		
		/** @var \app\ncmscore\core\Helpers $helpers */
		$helpers = \Yii::$app->helpers;
		
		if ($model instanceof ActiveModel) {
			foreach ($this->columns as $index => $column) {
				if (!$helpers->isFieldVisible($column, $model, 'list')) {
					unset($this->columns[$index]);
				}
			}
			
			$actionColumn = $this->getActionColumn($model);
			if (!is_null($actionColumn)) $this->columns[] = $actionColumn;
		}
	}

	/**
	 * Генерирует колонку с кнопками действий для модели
	 * @param ActiveModel $model
	 * @return array|null
	 */
	protected function getActionColumn(ActiveModel $model)
	{
		if (!$model->updateButton and !$model->deleteButton and !$model->viewButton) return null;
		
		return [
			'class' => 'yii\grid\ActionColumn',
			'template' => ($model->viewButton ? '{view} ' : '') . ($model->updateButton ? '{update} ' : '') . ($model->deleteButton ? '{delete}' : ''),
		];
	}
}