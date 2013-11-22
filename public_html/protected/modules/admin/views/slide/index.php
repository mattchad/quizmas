<div class="page-header">
	<h1>Homepage Slides <?php echo CHtml::link("Add Slide", array('slide/create'), array("class"=>'btn btn-large btn-primary pull-right')); ?></h1>
</div>

<table class="table table-bordered">
	<tr>
		<th>Headline</th>
		<th>Body</th>
		<th>Order Number</th>
		<th>Actions</th>
	</tr>
	<?php $this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_view',
	)); ?>
</table>
