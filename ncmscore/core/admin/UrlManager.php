<?php
/**
 * @package NCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 26.11.14
 */

namespace app\ncmscore\core\admin;

/**
 * UrlManager для панели администратора
 */
class UrlManager extends \yii\web\UrlManager
{

    /**
     * @inheritdoc
     */
    public function createUrl($params)
    {
        $params = (array)$params;

        $modelName = \Yii::$app->controller->getModelName();
        if (!array_key_exists('model', $params) and !empty($modelName)) {
            $params['model'] = $modelName;
        }

        return parent::createUrl($params);
    }
}
