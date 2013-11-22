<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'page-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('class'=>'form-horizontal', 'enctype'=>'multipart/form-data'),
)); ?>
	<div class="control-group">
		<?php echo $form->labelEx($PostageBookpack,'max_amount', array('class'=>'control-label')); ?>
		<div class="controls">
            <?php echo $form->textField($PostageBookpack,'max_amount',array('size'=>5,'maxlength'=>5, 'class'=>'span1')); ?>
			<?php echo $form->error($PostageBookpack,'max_amount'); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->labelEx($PostageBookpack,'price', array('class'=>'control-label')); ?>
		<div class="controls">
			<div class="input-prepend">
                <span class="add-on">&pound;</span>
                <?php echo $form->textField($PostageBookpack,'price',array('size'=>7,'maxlength'=>7, 'class'=>'span1')); ?>
		    </div>
			<?php echo $form->error($PostageBookpack,'price'); ?>
		</div>
	</div>
	<div class="form-actions">
		<?php echo CHtml::submitButton($PostageBookpack->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->