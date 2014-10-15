<?php
/**
 * @package NCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 15.10.14
 */

namespace NCMS\admin;

/**
 * Компонент для рендеринга таблицы с полной информацией о обьекте
 * @package NCMS\admin
 */
class FullViewItemRenderer extends \NCMS\ARenderer {

 /**
  * Рендеринг компонента
  * @return string
  */
 public function render()
 {
  $result = '<div class="view">';

  foreach ($this->model->attributes as $attr => $attrValue)
  {
   if (!$this->isAttrHidden($attr))
   {
	$result .= '<b>'.$this->model->getAttributeLabel($attr).'</b>: '.$attrValue.'<br>';
   }
  }

  $result .= '<footer class="footer" style="padding-top: 10px;">'.
	           \CHtml::link('Редактировать', array('edit', 'id'=>$this->model->id, 'model'=>get_class($this->model))).' '.
			   \CHtml::link('Удалить', array('delete', 'id'=>$this->model->id, 'model'=>get_class($this->model))).'
			   </footer>
			  </div>';
  
  return $result;
 }
}