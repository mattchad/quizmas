<tr>
	<td><?php echo CHtml::link(CHtml::encode($data->name), array('course/update', 'id'=>$data->id)); ?></td>
	<td>
		<?php echo sizeof($data->instances); ?>
	</td>
	<td class="index_actions"><?php echo CHtml::link("Edit", array('course/update', 'id'=>$data->id), array("class"=>'btn')) . CHtml::link("Delete", array('course/delete', 'id'=>$data->id), array("class"=>'btn btn-danger')); ?></td>
</tr>