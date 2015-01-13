<?php
/**
 * @package NCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 19.11.14
 */

namespace app\ncmscore\widgets;

use app\ncmscore\core\Helpers;
use app\ncmscore\core\ModelColumnsExploder;
use app\ncmscore\models\ActiveModel;

/**
 * Класс для детального просмотра элемента
 */
class DetailView extends \yii\widgets\DetailView {

	/**
	 * @inheritdoc
	 */
	protected function normalizeAttributes() {
		if (is_null($this->attributes) and $this->model instanceof ActiveModel) {
			if (!is_array($this->attributes)) {
				$this->attributes = [];
			}
			
			$this->attributes = array_merge($this->attributes, ModelColumnsExploder::getViewAttributes($this->model));
		}
		
		parent::normalizeAttributes();
		
		/** @var Helpers $helpers */
		$helpers = \Yii::$app->helpers;
		
		foreach ($this->attributes as $index => $attr) {
			if (!$helpers->isFieldVisible($attr['attribute'], $this->model, $helpers::VIEW_TYPE_VIEW)) {
				unset($this->attributes[$index]);
			}
		}
		
		if ($this->model->updateButton or $this->model->deleteButton) {
			$actionColumn = new DetailViewActionColumn();
			$actionColumn->template = ($this->model->updateButton ? '{update} ' : '') . ($this->model->deleteButton ? '{delete}' : '');
			
			
			$this->attributes[] = [
				'attribute' => 'editButtons',
				'format' => 'raw',
				'label' => 'Редактировать',
				'value' => $actionColumn->renderDataCell($this->model, $this->model->id, 0),
			];
		}
	}
}