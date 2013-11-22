<tr>
	<td><?php echo CHtml::link(CHtml::encode($data->name), array('target/update', 'id'=>$data->id)); ?></td>
	<td class="index_actions"><?php echo CHtml::link("Edit", array('target/update', 'id'=>$data->id), array("class"=>'btn')) . CHtml::link("Delete", array('target/delete', 'id'=>$data->id), array("class"=>'btn btn-danger')); ?></td>
</tr>