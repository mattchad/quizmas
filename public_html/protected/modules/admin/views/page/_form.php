<?php
/* @var $this PageController */
/* @var $model Page */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'page-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype'=>'multipart/form-data', 'class'=>'form-horizontal'),
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="control-group">
		<?php echo $form->labelEx($model,'title', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>100, 'class'=>'span4')); ?>
			<?php echo $form->error($model,'title'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'body', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textArea($model,'body',array('rows'=>15, 'cols'=>50, 'class'=>'span6')); ?>
			<?php echo $form->error($model,'body'); ?>
			<?php echo $this->text_formatting; ?>
		</div>
	</div>
	
	<div class="control-group checkboxlist">
		<?php echo $form->labelEx($model,'images', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php 
				if(sizeof(CHtml::listData($model->pageImages, 'id', 'filename')))
				{
					echo '<div class="current_page_images">';
					echo '<p class="checkboxlist_help">Check below to delete</p>';
					echo $form->checkBoxList($model, 'images', CHtml::listData($model->pageImages, 'id', 'filename'));
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
				if(sizeof(CHtml::listData($model->pageDownloads, 'id', 'filename')))
				{
					echo '<div class="current_page_images">';
					echo '<p class="checkboxlist_help">Check below to delete</p>';
					echo $form->checkBoxList($model, 'downloads', CHtml::listData($model->pageDownloads, 'id', 'filename'));
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
	<div class="control-group">
		<?php echo $form->labelEx($model,'status', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->radioButtonList($model,'status',array('1'=>"Online", '0'=>'Offline')); ?>
			<?php echo $form->error($model,'status'); ?>
		</div>
	</div>
	<div class="form-actions">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); ?>
		<?php 
		    if(!$model->isNewRecord)
		    {
		        echo CHtml::link(($model->status == Page::STATUS_ONLINE ? 'View' : 'Preview') . ' page', array('/page/view', 'id'=>$model->id), array('class'=>'btn')); 
            }
        ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->