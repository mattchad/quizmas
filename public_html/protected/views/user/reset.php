<div class="page-header">
    <h1>Reset Password</h1>
</div>
<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'htmlOptions'=>array('class'=>'form-horizontal')    
    )); ?>
    <div class="form-group <?php echo !is_null($User->getError('password')) ? 'has-error' : ''; ?>">
        <?php echo $form->labelEx($User,'password', array('class'=>'col-sm-3 control-label')); ?>
        <div class="col-sm-4">
            <?php echo $form->passwordField($User,'password', array('class'=>'form-control')); ?>
            <?php echo !is_null($User->getError('password')) ? '<span class="help-block">' . $form->error($User,'password') .'</span>' : ''; ?>
        </div>
    </div>
    <div class="form-group <?php echo !is_null($User->getError('password_repeat')) ? 'has-error' : ''; ?>">
        <?php echo $form->labelEx($User,'password_repeat', array('class'=>'col-sm-3 control-label')); ?>
        <div class="col-sm-4">
            <?php echo $form->passwordField($User,'password_repeat', array('class'=>'form-control')); ?>
            <?php echo !is_null($User->getError('password_repeat')) ? '<span class="help-block">' . $form->error($User,'password_repeat') .'</span>' : ''; ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-10">
            <?php echo CHtml::submitButton("Change Password", array('class' => 'btn btn-primary')); ?>
            <?php echo CHtml::link("Cancel", array('site/index'), array('class'=>'btn btn-link')); ?>
        </div>
    </div>
	<?php $this->endWidget(); ?>
</div>
