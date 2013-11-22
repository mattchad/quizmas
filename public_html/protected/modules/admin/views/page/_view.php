<tr>
	<td><?php echo CHtml::link(CHtml::encode($data->title), array('page/update', 'id'=>$data->id)); ?></td>
	<td class="index_actions"><?php echo CHtml::link("Edit", array('page/update', 'id'=>$data->id), array("class"=>'btn')) . (!sizeof($data->nav) ? CHtml::link("Delete", array('page/delete', 'id'=>$data->id), array("class"=>'btn btn-danger')) : '' ); ?></td>
</tr>