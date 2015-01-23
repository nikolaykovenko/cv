<?php

namespace app\controllers;

use app\models\Categories;
use Yii;
use yii\web\Controller;

/**
 * Контроллер стартовой страницы
 * @package app\controllers
 */
class SiteController extends Controller
{
    /**
     * @var Categories[]
     */
    public $categories;

    /**
     * @var array
     */
    public $mainNavItems = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->categories = Categories::find()->all();

        foreach ($this->categories as $category) {
            $this->mainNavItems[] = [
                'label' => $category->caption,
                'url' => '#' . $category->static,
            ];
        }

        parent::init();
    }


    /**
     * Отображение стартовой страницы
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
