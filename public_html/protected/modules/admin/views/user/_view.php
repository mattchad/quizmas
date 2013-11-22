<tr>
	<td><?php echo CHtml::link(CHtml::encode($data->first_name . ' ' . $data->last_name), array('user/update', 'id'=>$data->id)); ?></td>
	<td>
	    <?php 
    	    switch($data->role)
    	    {
        	    case User::ROLE_USER:
        	    {
            	    echo 'User';
            	    break;
        	    }
        	    case User::ROLE_EDITOR:
        	    {
            	    echo 'Editor';
            	    break;
        	    }
        	    default:
        	    {
            	    echo 'Administrator';
        	    }
    	    }
	    ?>
	</td>
	<td class="index_actions"><?php echo CHtml::link("Edit", array('user/update', 'id'=>$data->id), array("class"=>'btn')) . CHtml::link("Delete", array('user/delete', 'id'=>$data->id), array("class"=>'btn btn-danger')); ?></td>
</tr>