<tr>
	<td><?php echo CHtml::encode($data->id); ?></td>
	<td><?php echo CHtml::link(CHtml::encode($data->title), array('publication/update', 'id'=>$data->id)); ?></td>
	<td class="index_actions"><?php echo CHtml::link("Edit", array('publication/update', 'id'=>$data->id), array("class"=>'btn')) . CHtml::link("Delete", array('publication/delete', 'id'=>$data->id), array("class"=>'btn btn-danger')); ?></td>
</tr>