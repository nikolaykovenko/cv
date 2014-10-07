<?php
/* @var $this ParameterValuesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Parameter Values',
);

$this->menu=array(
	array('label'=>'Create ParameterValues', 'url'=>array('create')),
	array('label'=>'Manage ParameterValues', 'url'=>array('admin')),
);
?>

<h1>Parameter Values</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
