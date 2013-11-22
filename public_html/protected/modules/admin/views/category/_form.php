<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'category-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('class'=>'form-horizontal', 'enctype'=>'multipart/form-data'),
)); ?>

	<div class="control-group">
		<?php echo $form->labelEx($Category,'name', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($Category,'name',array('size'=>60,'maxlength'=>100, 'class'=>'span4')); ?>
			<?php echo $form->error($Category,'name'); ?>
		</div>
	</div>
	<div class="form-actions">
		<?php echo CHtml::submitButton($Category->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->