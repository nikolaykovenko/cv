<?php
/**
 * @package NCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 11.02.15
 */

namespace app\ncmscore\core;

use app\ncmscore\models\ActiveModel;
use yii\base\Component;

/**
 * Класс для работы с параметрами приложения
 * @package app\ncmscore\core
 */
class Config extends Component
{

    /**
     * @var array|null значения параметров
     */
    private $params = null;

    /**
     * @var ActiveModel
     */
    private $model;

    /**
     * Возвращает значение параметра
     * @param string $param
     * @return mixed
     */
    public function param($param)
    {
        if (is_null($this->params)) {
            $this->loadConfigParams();
            $this->loadDBParams();
        }
        
        if (isset($this->params[$param])) {
            return $this->params[$param];
        }
        
        return null;
    }

    /**
     * Устанавливает название модели с настройками приложения
     * @param string $modelName
     * @return $this
     * @throws \Exception в случае неудачи
     */
    public function setModelName($modelName)
    {
        $model = \Yii::createObject($modelName);
        return $this->setModel($model);
    }

    /**
     * Устанавливает модель с настройками приложения
     * @param ActiveModel $model
     * @return $this
     */
    public function setModel(ActiveModel $model)
    {
        $this->model = $model;
        $this->params = null;
        return $this;
    }


    /**
     * Получает дополнительные параметры из файла конфигурации
     * @return bool
     */
    private function loadConfigParams()
    {
        $data = \Yii::$app->params;
        foreach ($data as $param => $value) {
            $this->params[$param] = $value;
        }
        
        return true;
    }

    /**
     * Получает параметры из БД и записывает в конфиг
     * @return bool
     */
    private function loadDBParams()
    {
        $model = $this->model;
        $data = $model::find()->all();
        
        foreach ($data as $line) {
            $this->params[$line->param] = $line->value;
        }
        
        return true;
    }
}
