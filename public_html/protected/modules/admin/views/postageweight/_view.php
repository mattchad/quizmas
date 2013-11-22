<tr>
	<td><?php echo CHtml::encode($data->max_weight); ?>g</td>
	<td>&pound;<?php echo CHtml::encode($data->price); ?></td>
	<td class="index_actions"><?php echo CHtml::link("Update", array('postageweight/update', 'id'=>$data->id), array("class"=>'btn')) . CHtml::link("Delete", array('postageweight/delete', 'id'=>$data->id), array("class"=>'btn btn-danger')); ?></td>
</tr>