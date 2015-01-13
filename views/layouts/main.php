<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

$this->registerCssFile('/css/style.css', [
	'depends' => [\yii\bootstrap\BootstrapAsset::className()]
]);
?>

<? $this->beginContent('@app/views/layouts/base.php'); ?>
<div class="container">
	<h1 class="main-h">Nikolay Kovenko - Curriculum Vitae</h1>
	<div class="row">
		<div class="col-sm-3">
			<?
			NavBar::begin([
				'renderInnerContainer' => false,
				'options' => [
					'class' => 'navbar-default main-nav',
				],
			]);
			echo Nav::widget([
				'items' => $this->context->mainNavItems,
				'options' => [
					'class' => 'nav-pills nav-stacked',
				],
			]);
			NavBar::end();
			?>
		</div>
		<main class="col-sm-9">
			<?= $content ?>
		</main>
	</div>
</div>

<? $this->endContent(); ?>