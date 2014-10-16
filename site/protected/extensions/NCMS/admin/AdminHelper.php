<?php
/**
 * @package NCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 16.10.14
 */

namespace NCMS\admin;


/**
 * Class ModulesNav
 * @package NCMS\admin
 */
class AdminHelper {

 /**
  * Возвращает главное меню модулей
  * @return array
  */
 public function getModulesNav()
 {
  $result = array();
  foreach (\Yii::app()->params['modules'] as $module => $caption) $result[] = array('label'=>$caption, 'url'=>array('/admin&model='.$module));
  return $result;
 }
}