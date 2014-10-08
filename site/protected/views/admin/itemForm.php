<?php
/** @var CController $this */
/** @var BaseActiveRecord $item  */
/** @var string $action */
?>

<div class="form">
 <?php
 $hidden_attr_method = $action.'HiddenAttributes';
 
 echo CHtml::beginForm().
	  CHtml::errorSummary($item);
 
 foreach ($item->attributes as $attr => $attrValue)
 {
  if (!in_array($attr, $item->$hidden_attr_method()))
  {
   echo '<div class="row">'.
	     CHtml::activeLabel($item, $attr);
   
   echo CHtml::activeTextField($item, $attr);
   
   echo '</div>';
  }
 }
 
 echo CHtml::submitButton('Сохранить').CHtml::endForm();
 ?>
</div>