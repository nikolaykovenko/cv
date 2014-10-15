<?php
/* @var $this CController */
/* @var $data BaseActiveRecord */
?>

<div class="view">
 <?php
  foreach ($data->attributes as $attr => $attrValue)
  {
   if (!in_array($attr, $data->listHiddenAttributes()))
   {
	$relation = $data->getActiveRelation($attr);
	
	echo '<b>'.$data->getAttributeLabel($attr).'</b>: ';
	
	if ($attr == 'external_parent')
	{
	 echo $data->externalParent->caption;
	}
	
	if (empty($relation)) echo $attrValue;
	else
	{
	 echo '<pre>';
	 print_r($data);
	 echo '</pre>';
	}
	
	echo '<br>';
   }
  }
 ?>
 
 <footer class="footer" style="padding-top: 10px;">
  <?php echo CHtml::link('Просмотреть', array('view', 'id'=>$data->id, 'model'=>get_class($data))); ?>
  <?php echo CHtml::link('Редактировать', array('edit', 'id'=>$data->id, 'model'=>get_class($data))); ?>
  <?php echo CHtml::link('Удалить', array('delete', 'id'=>$data->id, 'model'=>get_class($data))); ?>
 </footer>

</div>