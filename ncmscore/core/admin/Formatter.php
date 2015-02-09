<?php
/**
 * @package NCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 09.02.15
 */

namespace app\ncmscore\core\admin;


/**
 * Класс для форматирования данных определенного формата для админки
 * @package app\ncmscore\core\admin
 */
class Formatter extends \yii\i18n\Formatter {

    /**
     * Форматирование поля пароля
     * @param mixed $value the value to be formatted.
     * @return string
     */
    public function asPassword($value)
    {
        return $this->asHtml($value);
    }
}