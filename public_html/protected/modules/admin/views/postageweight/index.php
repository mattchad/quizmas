<div class="page-header">
	<h1>Postage Weight Ranges <?php echo CHtml::link("Add Postage Weight Range", array('postageweight/create'), array("class"=>'btn btn-large btn-primary pull-right')); ?></h1>
</div>

<table class="table table-bordered">
	<tr>
		<th>Maximum Weight</th>
		<th>Price</th>
		<th>Actions</th>
	</tr>
	<?php $this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_view',
	)); ?>
</table>
