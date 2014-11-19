<?php
/**
 * @package NCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 19.11.14
 */

namespace app\ncmscore\widgets;

use app\ncmscore\core\Helpers;

/**
 * Класс для детального просмотра элемента
 */
class DetailView extends \yii\widgets\DetailView {

	/**
	 * @inheritdoc
	 */
	protected function normalizeAttributes() {
		parent::normalizeAttributes();
		
		/** @var Helpers $helpers */
		$helpers = \Yii::$app->helpers;
		
		foreach ($this->attributes as $index => $attr) {
			if (!$helpers->isFieldVisible($attr['attribute'], $this->model, $helpers::VIEW_TYPE_VIEW)) {
				unset($this->attributes[$index]);
			}
		}
		
		if ($this->model->updateButton or $this->model->deleteButton) {
			
			$className = 'ff';
			
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