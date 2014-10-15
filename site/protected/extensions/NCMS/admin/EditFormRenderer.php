<?php
/**
 * @package NCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 14.10.14
 */

namespace NCMS\admin;

/**
 * Компонент для рендеринга формы редактирования элемента
 * @package NCMS\admin
 */
class EditFormRenderer extends \NCMS\ARenderer {

 /**
  * Рендеринг компонента
  * @return string
  */
 public function render()
 {
  $result = '<div class="form">'.
	        \CHtml::beginForm().
	        \CHtml::errorSummary($this->model);

  foreach ($this->model->attributes as $attr => $attrValue)
  {
   if (!$this->isAttrHidden($attr))
   {
	$relation = $this->getAttrRelation($attr);
	$result .= '<div class="row">'.
				\CHtml::activeLabel($this->model, $attr);


	if (!empty($relation) and get_class($relation) == 'CBelongsToRelation')
	{
	 $className = $relation->className;
	 $result .= \CHtml::activeDropDownList($this->model, $attr, \CHtml::listData($className::model()->findAll(), 'id', 'caption'));
	}
	else
	{
	 $result .= \CHtml::activeTextField($this->model, $attr);
	}

	$result .= '</div>';
   }
  }

  $result .= \CHtml::submitButton('Сохранить').\CHtml::endForm().
             '</div>';
  
  return $result;
 }
}