<?php
/* @var $this ParameterValuesController */
/* @var $model ParameterValues */

$this->breadcrumbs=array(
	'Parameter Values'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ParameterValues', 'url'=>array('index')),
	array('label'=>'Create ParameterValues', 'url'=>array('create')),
	array('label'=>'Update ParameterValues', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ParameterValues', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ParameterValues', 'url'=>array('admin')),
);
?>

<h1>View ParameterValues #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'external_parent',
		'caption',
		'value',
		'rate',
	),
)); ?>
