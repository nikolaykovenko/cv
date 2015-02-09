<?php
/**
 * @package default
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 17.11.14
 */

namespace app\ncmscore\models;

use app\ncmscore\models\scopes\Scope;
use yii\db\ActiveRecord;

/**
 * Базовая модель приложения
 */
class ActiveModel extends ActiveRecord
{

//	TODO: Вынести в отдельный класс, где будут хранится параметры для формирования страниц админки для модели

    /**
     * Массив скрытых полей
     *
     * Название поля может быть элементом массива или ключем.
     * Если название поле является ключем, его значением должно быть название (или массив) области скрытия
     * list|view|add|edit
     *
     * @var array
     */
    protected $hiddenFields = [
        'skills_matrix',
        'id' => ['update', 'create'],
        'password_hash' => 'list',
    ];

    /**
     * Массив типов полей. Нестандартные форматы:
     * relation - связь
     * longhtml - большое html наполнение (tinymce)
     * Значение по умолчанию - html
     *
     * @var array
     */
    protected $fieldTypes = [
        'rate' => 'integer',
        'id' => 'integer',
    ];

    /**
     * @var bool флаг отображения кнопки редактирования элемента
     */
    protected $updateButton = true;

    /**
     * @var bool флаг отображения кнопки удаления элемента
     */
    protected $deleteButton = true;

    /**
     * @var bool флаг отображения кнопки полного просмотра элемента
     */
    protected $viewButton = true;

    /**
     * Возвращает массив скрытых полей
     * @return array
     */
    public function getHiddenFields()
    {
        return $this->hiddenFields;
    }

    /**
     * Возвращает флаг отображения кнопки удаления элемента
     * @return boolean
     */
    public function getDeleteButton()
    {
        return $this->deleteButton;
    }

    /**
     * Возвращает флаг отображения кнопки удаления элемента
     * @return boolean
     */
    public function getUpdateButton()
    {
        return $this->updateButton;
    }

    /**
     * Возвращает флаг отображения кнопки полного просмотра элемента
     * @return boolean
     */
    public function getViewButton()
    {
        return $this->viewButton;
    }

    /**
     * Возвращает массив типов полей
     * @return array
     */
    public function getFieldTypes()
    {
        if (!is_array($this->fieldTypes)) {
            return [];
        }

        return $this->fieldTypes;
    }


    /**
     * @inheritdoc
     */
    public static function find()
    {
        return parent::find()->orderBy('rate desc');
    }
}
