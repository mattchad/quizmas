<tr>
	<td><?php echo CHtml::encode($data->id); ?></td>
	<td><?php echo CHtml::link(CHtml::encode($data->title), array('bookpack/update', 'id'=>$data->id)); ?></td>
	<td class="index_actions"><?php echo CHtml::link("Edit", array('bookpack/update', 'id'=>$data->id), array("class"=>'btn')) . CHtml::link("Delete", array('bookpack/delete', 'id'=>$data->id), array("class"=>'btn btn-danger')); ?></td>
</tr>