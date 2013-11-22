<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'page-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype'=>'multipart/form-data', 'class'=>'form-horizontal'),
)); ?>

	<div class="control-group">
		<?php echo $form->labelEx($model,'headline', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'headline',array('size'=>60,'maxlength'=>100, 'class'=>'span4')); ?>
			<?php echo $form->error($model,'headline'); ?>
		</div>
	</div>
	<?php if(!$model->isNewRecord){ ?>
	<div class="control-group">
		<?php echo $form->labelEx($model,'date', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php 
				$this->widget('zii.widgets.jui.CJuiDatePicker', array(
					'name'=>'post-date',
					'value' => $model->date,
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
			<?php echo $form->textField($model,'time' ,array('class'=>'span1')); ?>
			<?php echo $form->error($model,'date'); ?>
			<?php echo $form->error($model,'time'); ?>
		</div>
	</div>
	<?php } ?>
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
	<div class="control-group">
		<?php echo $form->labelEx($model,'image', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->fileField($model,'image',array('class'=>'span4')); ?>
			<?php echo $form->error($model,'image'); ?>
		</div>
	</div>
	
	<div class="control-group checkboxlist">
		<?php echo $form->labelEx($model,'images', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php 
				if(sizeof(CHtml::listData($model->news_images, 'id', 'filename')))
				{
					echo '<div class="current_page_images">';
					echo '<p class="checkboxlist_help">Check below to delete</p>';
					echo $form->checkBoxList($model, 'images', CHtml::listData($model->news_images, 'id', 'filename'));
					echo '</div>';
				}
			?>
			<?php 
				$this->widget('CMultiFileUpload', array(
					'name' => 'images',
					'accept' => 'jpeg|jpg', // useful for verifying files
					'duplicate' => 'Duplicate file!', // useful, i think
					'denied' => 'Invalid file type', // useful, i think
				));
			?>
		</div>
	</div>
	<div class="control-group checkboxlist">
		<?php echo $form->labelEx($model,'downloads', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php 
				if(sizeof(CHtml::listData($model->news_downloads, 'id', 'filename')))
				{
					echo '<div class="current_page_images">';
					echo '<p class="checkboxlist_help">Check below to delete</p>';
					echo $form->checkBoxList($model, 'downloads', CHtml::listData($model->news_downloads, 'id', 'filename'));
					echo '</div>';
				}
			?>
			<?php 
				$this->widget('CMultiFileUpload', array(
					'name' => 'downloads',
					'accept' => 'pdf, doc, docx, ppt, pptx, rtf, jpeg, jpg, eps, png', // useful for verifying files
					'duplicate' => 'Duplicate file!', // useful, i think
					'denied' => 'Invalid file type', // useful, i think
				));
			?>
		</div>
	</div>
		
	<div class="form-actions">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->