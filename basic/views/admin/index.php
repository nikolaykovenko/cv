<?php
/** @var \yii\web\View $this */
/** @var \yii\data\BaseDataProvider $dataProvider */

use \yii\helpers\Html;
use \app\ncmscore\helpers\admin\Url;
?>

<div class="text-right">
	<?= Html::a('Добавить', Url::to(['admin/create']), ['class' => 'btn btn-primary']); ?>
</div>

<?php if (!empty($this->context->message)): ?>
	<?= \yii\bootstrap\Alert::widget([
		'body' => $this->context->message,
		'options' => [
			'class' => $this->context->messageClass
		]
	]); ?>
<?php endif; ?>

<?= \app\ncmscore\widgets\GridView::widget([
	'dataProvider' => $dataProvider
]); ?>