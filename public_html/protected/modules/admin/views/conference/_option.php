<h2>Option <?php echo ($index + 1);?> <?php echo CHtml::link("Delete", array('eventinstance/delete', 'id' => $data->id), array('class'=>'btn btn-small btn-danger pull-right', 'confirm'=>'Are you sure you want to delete this option?')) . CHtml::link("View Sessions", array('eventinstance/update', 'id' => $data->id), array('class'=>'btn btn-small pull-right'));?></h2>
<ul>
	<?php 
		foreach($data->sessions as $session)
		{
			echo '<li>' . date('l, jS F Y - H:i', $session->start_time) . ' to ' . date('H:i', $session->end_time) . '</li>';
		}
	?>
</ul>
<hr />