<div class="page-header">
    <h1>Login</h1>
</div>
<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'htmlOptions'=>array('class'=>'form-horizontal')    
    )); ?>
    <div class="form-group <?php echo !is_null($LoginForm->getError('email_address')) ? 'has-error' : ''; ?>">
        <?php echo $form->labelEx($LoginForm,'email_address', array('class'=>'col-sm-3 control-label')); ?>
        <div class="col-sm-4">
            <?php echo $form->textField($LoginForm,'email_address', array('class'=>'form-control')); ?>
            <?php echo !is_null($LoginForm->getError('email_address')) ? '<span class="help-block">' . $form->error($LoginForm,'email_address') .'</span>' : ''; ?>
        </div>
    </div>
    <div class="form-group <?php echo !is_null($LoginForm->getError('password')) ? 'has-error' : ''; ?>">
        <?php echo $form->labelEx($LoginForm,'password', array('class'=>'col-sm-3 control-label')); ?>
        <div class="col-sm-4">
            <?php echo $form->passwordField($LoginForm,'password', array('class'=>'form-control')); ?>
            <?php echo !is_null($LoginForm->getError('password')) ? '<span class="help-block">' . $form->error($LoginForm,'password') .'</span>' : ''; ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-10">
            <?php echo CHtml::submitButton("Login", array('class' => 'btn btn-primary')); ?>
            <?php echo CHtml::link("Forgotten Password", array('site/reset'), array('class'=>'btn btn-link')); ?>
        </div>
    </div>
	<?php $this->endWidget(); ?>
</div>