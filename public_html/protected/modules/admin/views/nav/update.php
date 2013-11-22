<div class="page-header">
	<?php $Page = Page::model()->findByPk($Nav->page_id); ?>
	<h1><?php echo $Page->title; ?></h1>
</div>
<h3>Add a page to this section</h3>
<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'nav-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php if($form->errorSummary($NavItem)){ ?>
	<div class="alert alert-error">
		<?php echo $form->errorSummary($NavItem); ?>
	</div>
<?php } ?>
<table class="table table-bordered">
	<tr>
		<th><?php echo $form->labelEx($NavItem,'guid');?></th>
		<th><?php echo $form->labelEx($NavItem,'order_number');?></th>
		<th></th>
	</tr>
	<tr>
		<td id="page_listing_choice"><select id="page_listing_choices"><option value="0">I want to add a...</option><option value="1">Page Item</option><option value="2">Item Listing</option></select>&nbsp;&nbsp;<span class="page"><?php echo $form->dropDownList($NavItem,'page_choice', $Pages, array("empty"=>"Select a Page")); ?></span><span class="listing"><?php echo $form->dropDownList($NavItem, 'listing_choice', $listing_options, array("empty"=>"Select a listing page")); ?></span></td>
		<td class="span2"><?php echo $form->textField($NavItem,'order_number', array('class'=>'span1')); ?></td>
		<td class="span2 center"><?php echo CHtml::submitButton('Add Page', array('class'=>'btn btn-primary'));?></td>
	</tr>
</table>
<?php $this->endWidget(); ?>
<h3>Pages in this section</h3>
<?php echo CHtml::beginForm(); ?>
<table class="table table-bordered">
	<tr>
		<th>Page</th>
		<th>Order</th>
		<th>Actions</th>
	</tr>
	<?php foreach($NavItems as $NavItem){ ?>
		<tr>
			<td><?php echo $NavItem->guid; ?><?php echo CHtml::hiddenField('nav_item[' . $NavItem->id . '][id]', $NavItem->id); ?></td>
			<td class="span2"><?php echo CHtml::textField('nav_item[' . $NavItem->id . '][order]', $NavItem->order_number, array('class'=>'span1')); ?></td>
			<td class="span2 center"><?php echo CHtml::link("Remove", array("navitem/delete", 'id'=>$NavItem->id, 'section'=>$NavItem->nav_id), array("class"=>'btn btn-danger')); ?></td>
		</tr>
	<?php } ?>
</table>
<div class="form-actions">
	<?php echo CHtml::submitButton('Save Order', array('class'=>'btn btn-primary pull-right'));?>
</div>
<?php echo CHtml::endForm(); ?>
