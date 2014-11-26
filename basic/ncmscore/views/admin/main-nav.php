<?php
/** @var $this \yii\web\View */
/** @var array $nav */

use \yii\helpers\Url;
?>
<nav>
	<ul class="nav nav-pills nav-stacked">
		<? foreach ($nav as $partCaption => $navArray): ?>
			<li><h5 class="h"><?= $partCaption ?></h5></li>
			<? foreach ($navArray as $model => $caption): ?>
				<li<?= $model == Yii::$app->controller->modelName ? ' class="active"' : '' ?>><a href="<?= Url::toRoute(['admin/index', 'model' => $model]) ?>"><?= $caption ?></a></li>
			<? endforeach ?>
		<? endforeach ?>

		<?
		/*
		 * {if $part_caption != $CI->config->item('standard_modules_caption') or !in_array($nav_static, $CI->config->item('standard_modules_hidden_main_nav'))}
		 * <li style="padding-top: 30px;"><h5 class="h">Языковые версии</h5></li>
		{foreach from=$CI->langs_model->load_all() item="lang"}
		<li{if $CI->app_lang == $lang->value} class="active"{/if}> <a href="{$CI->url_maker->url(null, null, {$lang->value}, null, true)}">{$lang->caption}</a></li>
		{/foreach}
		 * */
		?>


	</ul>
</nav>