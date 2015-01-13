<?php
/** @var \app\ncmscore\models\ActiveModel $model */
/** @var \yii\web\View $this */
?>

<?= \app\ncmscore\widgets\DetailView::widget([
	'model' => $model
]); ?>

<?// TODO: Перенести в layout ?>
<?= isset($dataProvider) ? $this->render('index', ['dataProvider' => $dataProvider]) : '' ?>