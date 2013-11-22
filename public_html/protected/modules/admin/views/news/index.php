<div class="page-header">
	<h1>News Stories <?php echo CHtml::link("Add News Story", array('news/create'), array("class"=>'btn btn-large btn-primary pull-right')); ?></h1>
</div>

<table class="table table-bordered">
	<tr>
		<th>ID</th>
		<th>Headline</th>
		<th>Date</th>
		<th>Actions</th>
	</tr>
	<?php $this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_view',
	)); ?>
</table>
