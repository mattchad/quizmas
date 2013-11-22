<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'page-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('class'=>'form-horizontal', 'enctype'=>'multipart/form-data'),
)); ?>
    <?php echo CHtml::errorSummary($User); ?>
	<div class="control-group">
		<?php echo $form->labelEx($User,'first_name', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($User,'first_name',array('size'=>50,'maxlength'=>50, 'class'=>'span4')); ?>
			<?php echo $form->error($User,'first_name'); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->labelEx($User,'last_name', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($User,'last_name',array('size'=>50,'maxlength'=>50, 'class'=>'span4')); ?>
			<?php echo $form->error($User,'last_name'); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->labelEx($User,'email_address', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($User,'email_address',array('size'=>150,'maxlength'=>150, 'class'=>'span4')); ?>
			<?php echo $form->error($User,'email_address'); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->labelEx($User,'role', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->dropDownList($User,'role',array(User::ROLE_USER => 'User', User::ROLE_EDITOR => 'Editor', User::ROLE_ADMIN => 'Administrator')); ?>
			<?php echo $form->error($User,'role'); ?>
		</div>
	</div>
	<div class="form-actions">
		<?php echo CHtml::submitButton('Save', array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->