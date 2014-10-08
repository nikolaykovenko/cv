<?php
/**
 * @package NCMS_Base
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 07.10.14
 */

/**
 * Базовая модель
 */
abstract class BaseActiveRecord extends CActiveRecord {

 /**
  * Сортировка по умолчанию
  * @return array
  */
 public function defaultScope()
 {
  return array('order'=>'rate desc, id');
 }

 /**
  * Массив атрибутов, которые скрываются в списке элементов
  * @return array
  */
 public function listHiddenAttributes()
 {
  return array();
 }

 /**
  * Массив атрибутов, которые скрываются в форме создания нового элемента
  * @return array
  */
 public function addHiddenAttributes()
 {
  return array('id');
 }

 /**
  * Массив атрибутов, которые скрываются в форме редактирования элемента
  * @return array
  */
 public function editHiddenAttributes()
 {
  return $this->addHiddenAttributes();
 }
}