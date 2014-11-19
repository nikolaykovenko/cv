<?php
/** @var \yii\data\BaseDataProvider $dataProvider */
/** @var string $message */
/** @var string $messageClass */
?>

<?= \yii\bootstrap\Alert::widget([
	'body' => $message,
	'options' => [
		'class' => $messageClass
	]
]) ?>

<?= \app\ncmscore\widgets\GridView::widget([
	'dataProvider' => $dataProvider
]); ?>