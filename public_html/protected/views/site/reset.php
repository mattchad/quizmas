<h1>Reset Password</h1>
	<?php if($reset_sent){ ?>
		<p>You will shortly receive an email. Follow the instructions to enter a new password.</p>
	<?php } else { ?>
	    <div class="form">
    	    <?php $form=$this->beginWidget('CActiveForm', array(
    			'id'=>'reset-form',
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
    		<div class="actions">
    			<?php 
    				echo CHtml::submitButton("Reset Password", array('class' => 'button'));
    			?>
    		</div>
    		<?php $this->endWidget(); ?>
		</div>
	<?php } ?>