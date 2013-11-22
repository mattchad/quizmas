<h2><?php echo (strlen($data->author) ? $data->author : 'Anonymous'); ?><?php echo CHtml::link("Delete", array('publicationquote/delete', 'id' => $data->id), array('class'=>'btn btn-small btn-danger pull-right', 'confirm'=>'Are you sure you want to delete this quote?'));?></h2>
<p><?php echo $data->quote; ?></p>
<hr />
