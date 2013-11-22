<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'page-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('class'=>'form-horizontal', 'enctype'=>'multipart/form-data'),
)); ?>

	<div class="control-group">
		<?php echo $form->labelEx($model,'headline', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'headline',array('size'=>60,'maxlength'=>100, 'class'=>'span4')); ?>
			<?php echo $form->error($model,'headline'); ?>
		</div>
	</div>
    <div class="control-group character_count">
		<?php echo $form->labelEx($model,'body', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textArea($model,'body',array('rows'=>5, 'cols'=>50, 'class'=>'span6 count_input')); ?>
			<?php echo $form->error($model,'body'); ?>
			<p class="count_number"><?php echo ($model->isNewRecord ? 0 : strlen(trim($model->body)));?> characters</p>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->labelEx($model,'image', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->fileField($model,'uploaded_image',array('class'=>'span4')); ?>
			<?php echo $form->error($model,'uploaded_image'); ?>
			<?php 
				if(!$model->isNewRecord)
				{
					echo '<p><br /><img width="200" src="' . $model->imageUrl . '?time=' . time() . '" /></p>';
				}
			?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->labelEx($model,'slide_url', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'slide_url',array('size'=>60,'maxlength'=>250, 'class'=>'span4')); ?>
			<?php echo $form->error($model,'slide_url'); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->labelEx($model,'order_number', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'order_number',array('size'=>2,'maxlength'=>3, 'class'=>'span1')); ?>
			<?php echo $form->error($model,'order_number'); ?>
		</div>
	</div>
	<div class="form-actions">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->