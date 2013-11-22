<h2><?php echo (strlen($data->author) ? $data->author : 'Anonymous'); ?><?php echo CHtml::link("Delete", array('eventquote/delete', 'id' => $data->id), array('class'=>'btn btn-small btn-danger pull-right delete_confirm'));?></h2>
<p><?php echo $data->quote; ?></p>
<hr />
