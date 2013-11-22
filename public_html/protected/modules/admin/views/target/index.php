<div class="page-header">
	<h1>Target <?php echo CHtml::link("Add Target", array('target/create'), array("class"=>'btn btn-large btn-primary pull-right')); ?></h1>
</div>

<table class="table table-bordered">
	<tr>
		<th>Name</th>
		<th>Actions</th>
	</tr>
	<?php $this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_view',
	)); ?>
</table>
