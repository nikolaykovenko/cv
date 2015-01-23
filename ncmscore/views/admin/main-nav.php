<?php
/** @var $this \yii\web\View */
/** @var array $nav */

use \yii\helpers\Url;

?>
<nav>
    <ul class="nav nav-pills nav-stacked">
        <?php foreach ($nav as $partCaption => $navArray): ?>
            <li><h5 class="h"><?= $partCaption ?></h5></li>
            <?php foreach ($navArray as $model => $caption): ?>
                <li<?= $model == Yii::$app->controller->modelName ? ' class="active"' : '' ?>><a
                        href="<?= Url::toRoute(['admin/index', 'model' => $model]) ?>"><?= $caption ?></a></li>
            <?php endforeach ?>
        <?php endforeach ?>
    </ul>
</nav>