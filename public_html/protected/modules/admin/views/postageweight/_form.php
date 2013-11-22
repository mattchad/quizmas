<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'page-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('class'=>'form-horizontal', 'enctype'=>'multipart/form-data'),
)); ?>
	<div class="control-group">
		<?php echo $form->labelEx($PostageWeight,'max_weight', array('class'=>'control-label')); ?>
		<div class="controls">
			<div class="input-append">
                <?php echo $form->textField($PostageWeight,'max_weight',array('size'=>5,'maxlength'=>5, 'class'=>'span1')); ?>
                <span class="add-on">g</span>
		    </div>
			<?php echo $form->error($PostageWeight,'max_weight'); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->labelEx($PostageWeight,'price', array('class'=>'control-label')); ?>
		<div class="controls">
			<div class="input-prepend">
                <span class="add-on">&pound;</span>
                <?php echo $form->textField($PostageWeight,'price',array('size'=>7,'maxlength'=>7, 'class'=>'span1')); ?>
		    </div>
			<?php echo $form->error($PostageWeight,'price'); ?>
		</div>
	</div>
	<div class="form-actions">
		<?php echo CHtml::submitButton($PostageWeight->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->