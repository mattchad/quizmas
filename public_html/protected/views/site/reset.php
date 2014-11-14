<div class="page-header">
    <h1>Reset Password</h1>
</div>
<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'htmlOptions'=>array('class'=>'form-horizontal')    
    )); ?>
    <div class="form-group <?php echo !is_null($ResetForm->getError('email_address')) ? 'has-error' : ''; ?>">
        <?php echo $form->labelEx($ResetForm,'email_address', array('class'=>'col-sm-3 control-label')); ?>
        <div class="col-sm-4">
            <?php echo $form->textField($ResetForm,'email_address', array('class'=>'form-control')); ?>
            <?php echo !is_null($ResetForm->getError('email_address')) ? '<span class="help-block">' . $form->error($ResetForm,'email_address') .'</span>' : ''; ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-10">
            <?php echo CHtml::submitButton("Reset Password", array('class' => 'btn btn-primary')); ?>
        </div>
    </div>
	<?php $this->endWidget(); ?>
</div>
