<tr>
	<td><?php echo CHtml::encode($data->max_amount); ?></td>
	<td>&pound;<?php echo CHtml::encode($data->price); ?></td>
	<td class="index_actions"><?php echo CHtml::link("Update", array('postagebookpack/update', 'id'=>$data->id), array("class"=>'btn')) . CHtml::link("Delete", array('postagebookpack/delete', 'id'=>$data->id), array("class"=>'btn btn-danger')); ?></td>
</tr>