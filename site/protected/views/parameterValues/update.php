<?php
/* @var $this ParameterValuesController */
/* @var $model ParameterValues */

$this->breadcrumbs=array(
	'Parameter Values'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ParameterValues', 'url'=>array('index')),
	array('label'=>'Create ParameterValues', 'url'=>array('create')),
	array('label'=>'View ParameterValues', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ParameterValues', 'url'=>array('admin')),
);
?>

<h1>Update ParameterValues <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>