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
	echo '<b>'.$data->getAttributeLabel($attr).'</b>: '.$attrValue.'<br>';
   }
  }
 ?>
 
 <footer class="footer" style="padding-top: 10px;">
  <?php echo CHtml::link('Просмотреть', array('view', 'id'=>$data->id, 'model'=>get_class($data))); ?>
  <?php echo CHtml::link('Редактировать', array('edit', 'id'=>$data->id, 'model'=>get_class($data))); ?>
  <?php echo CHtml::link('Удалить', array('delete', 'id'=>$data->id, 'model'=>get_class($data))); ?>
 </footer>

</div>