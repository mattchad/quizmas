<div class="page-header">
	<h1>Books <?php echo CHtml::link("Add Book", array('book/create'), array("class"=>'btn btn-large btn-primary pull-right')); ?></h1>
</div>

<table class="table table-bordered">
	<tr>
		<th>Title</th>
		<th>Author</th>
		<th>Start Date</th>
		<th>Actions</th>
	</tr>
	<?php $this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_view',
	)); ?>
</table>
