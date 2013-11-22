<tr>
	<td><?php echo CHtml::link(CHtml::encode($data->headline), array('slide/update', 'id'=>$data->id)); ?></td>
	<td><?php echo CHtml::encode($data->body); ?></td>
	<td><?php echo CHtml::encode($data->order_number); ?></td>
	<td class="index_actions"><?php echo CHtml::link("Edit", array('slide/update', 'id'=>$data->id), array("class"=>'btn')) . CHtml::link("Delete", array('slide/delete', 'id'=>$data->id), array("class"=>'btn btn-danger', 'confirm'=>'Are you sure you want to delete this slide?')); ?></td>
</tr>