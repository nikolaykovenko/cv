<?php
/* @var $this ParameterValuesController */
/* @var $model ParameterValues */

$this->breadcrumbs=array(
	'Parameter Values'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ParameterValues', 'url'=>array('index')),
	array('label'=>'Manage ParameterValues', 'url'=>array('admin')),
);
?>

<h1>Create ParameterValues</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>