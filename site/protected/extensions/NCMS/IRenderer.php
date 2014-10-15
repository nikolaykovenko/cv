<?php
/**
 * @package NCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 14.10.14
 */

namespace NCMS;

/**
 * Интерфейс для компонентов рендеринга
 * @package NCMS
 */
interface IRenderer {

 /**
  * Рендеринг компонента
  * @return string
  */
 public function render();
}