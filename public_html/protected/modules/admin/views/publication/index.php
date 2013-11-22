<div class="page-header">
	<h1>Publications <?php echo CHtml::link("Add Publication", array('publication/create'), array("class"=>'btn btn-large btn-primary pull-right')); ?></h1>
</div>

<table class="table table-bordered">
	<tr>
		<th>ID</th>
		<th>Title</th>
		<th>Actions</th>
	</tr>
	<?php $this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_view',
	)); ?>
</table>
