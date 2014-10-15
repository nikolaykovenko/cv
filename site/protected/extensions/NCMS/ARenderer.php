<?php
/**
 * @package NCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 15.10.14
 */

namespace NCMS;

/**
 * Абстрактный рендерер
 * @package NCMS\admin
 */
abstract class ARenderer extends \CComponent implements IRenderer {

 /**
  * @var \CActiveRecord;
  */
 private $model;

 /**
  * @var null|array массив атрибутов со связями
  */
 private $relatedAttrs;

 /**
  * Конструктор
  * @param \CActiveRecord|null $model
  */
 function __construct(\CActiveRecord $model = null)
 {
  if (!is_null($model)) $this->setModel($model);
 }


 /**
  * Возвращает модель
  * @return \CActiveRecord
  * @throws \Exception если не задана
  */
 public function getModel()
 {
  if (is_null($this->model)) throw new \Exception('model error');
  return $this->model;
 }

 /**
  * Устанавливает модель
  * @param \CActiveRecord $model
  * @return $this
  */
 public function setModel(\CActiveRecord $model)
 {
  $this->model = $model;
  return $this;
 }


 /**
  * Возвращает массив спрятанных для заданного сценария атрибутов
  * @return array
  */
 protected function hiddenAttrs()
 {
  $method = $this->getModel()->scenario.'HiddenAttributes';
  if (method_exists($this->getModel(), $method))
  {
   $result = $this->getModel()->$method();
   if (is_array($result)) return $result;
  }

  return array();
 }

 /**
  * Проверяет, является ли атрибут скрытым для текущего сценария модели
  * @param string $attr
  * @return bool
  */
 protected function isAttrHidden($attr)
 {
  return in_array($attr, $this->hiddenAttrs());
 }

 /**
  * Возвращает тип связи для переданного атрибута
  * @param string $attr
  * @return null|string
  */
 protected function getAttrRelation($attr)
 {
  if (is_null($this->relatedAttrs)) $this->relatedAttrs = $this->getRelatedAttrs();
  
  if (array_key_exists($attr, $this->relatedAttrs)) return $this->relatedAttrs[$attr];
  return null;
 }

 /**
  * Возвращает ассоциативный массив атрибутов, которые участвуют в связях
  * Ключ - имя атрибута, значение - тип связи
  * @return array
  */
 private function getRelatedAttrs()
 {
  $result = array();
  $relations = $this->getModel()->relations();
  foreach ($relations as $relationName => $relation) $result[$relation[2]] = $this->getModel()->getActiveRelation($relationName);
  
  return $result;
 }
}