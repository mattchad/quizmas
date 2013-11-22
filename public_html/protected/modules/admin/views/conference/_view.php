<tr>
	<td><?php echo CHtml::link(CHtml::encode($data->name), array('conference/update', 'id'=>$data->id)); ?></td>
	<td>
		<?php echo sizeof($data->instances); ?>
	</td>
	<td class="index_actions"><?php echo CHtml::link("Edit", array('conference/update', 'id'=>$data->id), array("class"=>'btn')) . CHtml::link("Delete", array('conference/delete', 'id'=>$data->id), array("class"=>'btn btn-danger')); ?></td>
</tr>