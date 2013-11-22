<div class="page-header">
	<h1>Users <?php echo CHtml::link('Download Users', array('user/export'), array('class'=>'btn pull-right'));?></h1>
</div>

<table class="table table-bordered">
	<tr>
		<th>Name</th>
		<th>Role</th>
		<th>Actions</th>
	</tr>
	<?php $this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_view',
	)); ?>
</table>
