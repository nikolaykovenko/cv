<?php
/** @var $this Controller */
/** @var $content string */
//TODO: Замінити менюшку на віджет
?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="row">
<div class="col-sm-3">
 <nav class="navbar navbar-default" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
   <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav">
	<span class="sr-only">Toggle navigation</span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
   </button>
  </div>
  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="main-nav">
   <ul class="nav nav-pills nav-stacked">
	<?php foreach ($this->menu as $item): ?>
	 <li><a href="#<?= $item['static'] ?>"><?= $item['caption'] ?></a></li>
	<?php endforeach ?>
   </ul>
  </div><!-- /.navbar-collapse -->
 </nav>
</div>
<main class="col-sm-9">
<?= $content ?>
</main>
</div>
<?php $this->endContent('//layouts/main'); ?>