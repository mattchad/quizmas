<tr>
	<td><?php echo CHtml::encode($data->id); ?></td>
	<td><?php echo CHtml::link(CHtml::encode($data->headline), array('news/update', 'id'=>$data->id)); ?></td>
	<td><?php echo date("d/m/Y", $data->date); ?></td>
	<td class="index_actions"><?php echo CHtml::link("Edit", array('news/update', 'id'=>$data->id), array("class"=>'btn')) . CHtml::link("Delete", array('news/delete', 'id'=>$data->id), array("class"=>'btn btn-danger')); ?></td>
</tr>