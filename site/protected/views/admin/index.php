<?php
/** @var CController $this */
/** @var CModel $model  */
/** @var CActiveDataProvider $dataProvider  */
?>

<h1><?= get_class($model); ?></h1>
<?php
if (!empty($message)) echo '<div classs="message">'.$message.'</div>';

$this->widget('zii.widgets.ClistView', array('dataProvider'=>$dataProvider, 'itemView'=>'itemView'));
?>