<?php

use \app\ncmscore\widgets\ActiveForm;

/** @var \app\ncmscore\models\ActiveModel $model */
/** @var \yii\web\View $this */
?>

<div class="form">
	<?php ActiveForm::begin(['model' => $model]); ?>
	
	<?php ActiveForm::end(); ?>
</div>