<?php
/** @var CController $this */
/** @var CModel $model  */
/** @var BaseActiveRecord $item */
?>

<div class="view">
 <?php
 foreach ($item->attributes as $attr => $attrValue)
 {
  echo '<b>'.$item->getAttributeLabel($attr).'</b>: '.$attrValue.'<br>';
 }
 ?>

 <footer class="footer" style="padding-top: 10px;">
  <?php echo CHtml::link('Редактировать', array('edit', 'id'=>$item->id, 'model'=>get_class($item))); ?>
  <?php echo CHtml::link('Удалить', array('delete', 'id'=>$item->id, 'model'=>get_class($item))); ?>
 </footer>

</div>