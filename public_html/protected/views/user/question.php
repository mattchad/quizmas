<div class="page-header">
    <h1><?php echo $Question->isNewRecord ? 'Create' : 'Update'; ?> Question</h1>
</div>
<?php $form = $this->beginWidget('CActiveForm', array(
    'htmlOptions'=>array('class'=>'form-horizontal')    
)); ?>
<div class="form-group <?php echo !is_null($Question->getError('text')) ? 'has-error' : ''; ?>">
    <?php echo $form->labelEx($Question,'text', array('class'=>'col-sm-3 col-md-2 control-label')); ?>
    <div class="col-sm-6">
        <?php echo $form->textField($Question,'text', array('class'=>'form-control', 'maxlength'=>255)); ?>
        <?php echo !is_null($Question->getError('text')) ? '<span class="help-block">' . $form->error($Question,'text') .'</span>' : ''; ?>
    </div>
</div>
<div class="form-group <?php echo !is_null($Question->getError('value')) ? 'has-error' : ''; ?>">
    <?php echo $form->labelEx($Question,'value', array('class'=>'col-sm-3 col-md-2 control-label')); ?>
    <div class="col-sm-2">
        <?php echo $form->textField($Question,'value', array('class'=>'form-control', 'maxlength'=>3)); ?>
        <?php echo !is_null($Question->getError('value')) ? '<span class="help-block">' . $form->error($Question,'value') .'</span>' : ''; ?>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-3 col-md-offset-2 col-sm-10">
        <?php echo CHtml::submitButton($Question->isNewRecord ? 'Create' : 'Update', array('class' => 'btn btn-primary')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
