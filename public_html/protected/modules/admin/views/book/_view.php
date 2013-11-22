<tr>
	<td><?php echo CHtml::link(CHtml::encode($data->title), array('book/update', 'id'=>$data->id)); ?></td>
	<td><?php echo CHtml::encode($data->author); ?></td>
	<td><?php echo date('l, jS F Y', strtotime($data->start_date)); ?></td>
	<td class="index_actions"><?php echo CHtml::link("Edit", array('book/update', 'id'=>$data->id), array("class"=>'btn')) . CHtml::link("Delete", array('book/delete', 'id'=>$data->id), array("class"=>'btn btn-danger')); ?></td>
</tr>