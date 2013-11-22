<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'page-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('class'=>'form-horizontal'),
)); ?>
	<div class="control-group">
		<?php echo $form->labelEx($model,'name', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100, 'class'=>'span4')); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'description', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textArea($model,'description',array('rows'=>15, 'cols'=>50, 'class'=>'span6')); ?>
			<?php echo $form->error($model,'description'); ?>
		</div>
	</div>
	
	<div class="form-actions">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->