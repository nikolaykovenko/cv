<?php
/* @var $this \yii\web\View */
/* @var $content string */
?>

<? $this->beginContent('@app/views/layouts/base.php'); ?>

<div class="wrap">
	<div class="container">
		<div class="col-sm-3 col-lg-2">
			<h2 class="h3">NCMS</h2>
			<?= $this->render('@ncms-core-views/admin/main-nav', ['nav' => \Yii::$app->params['adminNav']]); ?>
		</div>
		<div class="col-sm-9 col-lg-10">
			<?= $content ?>
		</div>
	</div>
</div>


<footer class="footer">
	<div class="container">
		<p class="pull-left">&copy; NCMS V<?= '4.0 CV'; ?> <?= date('Y') ?></p>
		<p class="pull-right"><?= Yii::powered() ?></p>
	</div>
</footer>
<? $this->endContent(); ?>