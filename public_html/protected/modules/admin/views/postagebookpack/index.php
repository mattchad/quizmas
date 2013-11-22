<div class="page-header">
	<h1>Book Pack Postage ranges <?php echo CHtml::link("Add Book Pack Postage", array('postagebookpack/create'), array("class"=>'btn btn-large btn-primary pull-right')); ?></h1>
</div>

<table class="table table-bordered">
	<tr>
		<th>Maximum Amouont</th>
		<th>Price</th>
		<th>Actions</th>
	</tr>
	<?php $this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_view',
	)); ?>
</table>
