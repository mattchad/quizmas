<h1>Login</h1>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<div class="input_group">
		<?php echo $form->labelEx($model,'email_address'); ?>
		<div class="input_outer">
			<?php echo $form->textField($model,'email_address'); ?>
			<?php echo $form->error($model,'email_address', array('class'=>'text_error')); ?>
		</div>
	</div>
	<div class="input_group">
		<?php echo $form->labelEx($model,'password'); ?>
		<div class="input_outer">
			<?php echo $form->passwordField($model,'password'); ?>
			<?php echo $form->error($model,'password', array('class'=>'text_error')); ?>
		</div>
	</div>
	<div class="input_group">
		<div class="input_outer">
			<label for="LoginForm_rememberMe">
				<?php echo $form->checkBox($model,'rememberMe', array('class'=>'checkbox')); ?> Remember me for 30 days
			</label>
		</div>
	</div>
	<div class="actions">
		<?php echo CHtml::submitButton('Login', array('class'=>'button')); ?>
		<?php echo CHtml::link("Forgotten Password", array('site/reset'), array('class'=>'button')); ?>
	</div>
	<div class="actions">
		Or
	</div>
	<div class="actions">
		<?php echo CHtml::link("Register", array('user/register'), array('class'=>'button')); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
