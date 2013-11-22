<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'page-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('class'=>'form-horizontal', 'enctype'=>'multipart/form-data'),
)); ?>

	<div class="control-group">
		<?php echo $form->labelEx($model,'title', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>100, 'class'=>'span4')); ?>
			<?php echo $form->error($model,'title'); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->labelEx($model,'author', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'author',array('size'=>60,'maxlength'=>100, 'class'=>'span4')); ?>
			<?php echo $form->error($model,'author'); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->labelEx($model,'start_date', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php 
				$this->widget('zii.widgets.jui.CJuiDatePicker', array(
					'name'=>'start_date',
					'value' => $model->start_date,
					'htmlOptions'=>array(
						'size'=>60,
						'maxlength'=>100, 
						'class'=>'span2'
					),
					'options' => array(
						'dateFormat' => 'dd/mm/yy',
					)
				));
			?>
			<?php echo $form->error($model,'start_date'); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->labelEx($model,'image', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->fileField($model,'image',array('class'=>'span4')); ?>
			<?php echo $form->error($model,'image'); ?>
		</div>
	</div>
    <div class="control-group character_count">
		<?php echo $form->labelEx($model,'precis', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textArea($model,'precis',array('rows'=>5, 'cols'=>50, 'class'=>'span6 count_input')); ?>
			<?php echo $form->error($model,'precis'); ?>
			<p class="count_number"><?php echo ($model->isNewRecord ? 0 : strlen(trim($model->precis)));?> characters</p>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->labelEx($model,'description', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textArea($model,'description',array('rows'=>15, 'cols'=>50, 'class'=>'span6')); ?>
			<?php echo $form->error($model,'description'); ?>
			<?php echo $this->text_formatting; ?>
		</div>
	</div>
	
	<div class="form-actions">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->