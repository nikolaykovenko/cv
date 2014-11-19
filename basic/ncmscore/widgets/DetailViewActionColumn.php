<?php
/**
 * @package NCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 19.11.14
 */

namespace app\ncmscore\widgets;

use yii\grid\ActionColumn;

/**
 * Класс для автоматической генерации ActionColumn для Detail View
 */
class DetailViewActionColumn extends ActionColumn {

	/**
	 * Renders a data cell.
	 * @param mixed $model the data model being rendered
	 * @param mixed $key the key associated with the data model
	 * @param integer $index the zero-based index of the data item among the item array returned by [[GridView::dataProvider]].
	 * @return string the rendering result
	 */
	public function renderDataCell($model, $key, $index)
	{
		return $this->renderDataCellContent($model, $key, $index);
	}

	/**
	 * Renders the filter cell.
	 */
	public function renderFilterCell()
	{
		return $this->renderFilterCellContent();
	}

	/**
	 * @inheritdoc
	 */
	public function createUrl($action, $model, $key, $index)
	{
		$params = is_array($key) ? $key : ['id' => (string) $key];
		$params['model'] = \Yii::$app->helpers->shortClassName($model);
		
		return parent::createUrl($action, $model, $params, $index);
	}
}