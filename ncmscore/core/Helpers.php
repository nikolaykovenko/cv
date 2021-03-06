<?php
/**
 * @package NCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 18.11.14
 */

namespace app\ncmscore\core;

use app\ncmscore\models\ActiveModel;
use yii\base\Component;

/**
 * Базовый класс хелперов
 */
class Helpers extends Component
{

    /**
     * Список элементов
     */
    const VIEW_TYPE_LIST = 'list';

    /**
     * Детальное отображение элемента
     */
    const VIEW_TYPE_VIEW = 'view';

    /**
     * Создание элемента
     */
    const VIEW_TYPE_CREATE = 'create';

    /**
     * Обновление элемента
     */
    const VIEW_TYPE_UPDATE = 'update';

    /**
     * Проверяет, нужно ли отображать поле для текущего типа отображения
     * @param string $field
     * @param ActiveModel $model
     * @param null|string $viewType если не задан - извлекается из модели
     * @return bool
     */
    public function isFieldVisible($field, ActiveModel $model, $viewType = null)
    {
        $hiddenFields = $model->hiddenFields;
        if (empty($viewType)) {
            $viewType = $model->isNewRecord ? self::VIEW_TYPE_CREATE : self::VIEW_TYPE_UPDATE;
        }

        if (in_array($field, $hiddenFields) or
            (array_key_exists($field, $hiddenFields) and
                ($hiddenFields[$field] == $viewType or
                    (is_array($hiddenFields[$field]) and in_array($viewType, $hiddenFields[$field]))))) {
            return false;
        }

        return true;
    }

    /**
     * Возвращает краткое название модели
     * @param string|object $class
     * @return string
     */
    public function shortClassName($class)
    {
        $className = new \ReflectionClass($class);
        return $className->getShortName();
    }

    /**
     * Возвращает название главной модели для админки
     * @return string|null
     */
    public static function getAdminModelName()
    {
        $result = \Yii::$app->request->get('model');
        if (empty($result)) {
            return null;
        }

        return $result;
    }

    /**
     * Генерирует хеш пароля
     * @param string $password
     * @return string
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function generatePasswordHash($password)
    {
        if (empty($password) or !is_string($password)) {
            return '';
        }
        
        return \Yii::$app->getSecurity()->generatePasswordHash($password, 10);
    }
}
