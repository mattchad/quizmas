<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'page-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('class'=>'form-horizontal', 'enctype'=>'multipart/form-data'),
)); ?>
    <div class="accordion" id="accordion">
        <div class="accordion-group">
            <div class="accordion-heading">
                <h4><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#main_details">Main Details</a></h4>
            </div>
            <div id="main_details" class="accordion-body collapse in">
                <div class="accordion-inner">
                	<div class="control-group">
                		<?php echo $form->labelEx($model,'title', array('class'=>'control-label')); ?>
                		<div class="controls">
                			<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>100, 'class'=>'span4')); ?>
                			<?php echo $form->error($model,'title'); ?>
                		</div>
                	</div>
                	<div class="control-group">
                		<?php echo $form->labelEx($model,'price', array('class'=>'control-label')); ?>
                		<div class="controls">
                			<div class="input-prepend">
                                <span class="add-on">&pound;</span>
                                <?php echo $form->textField($model,'price',array('size'=>7,'maxlength'=>7, 'class'=>'span1')); ?>
                		    </div>
                			<?php echo $form->error($model,'price'); ?>
                		</div>
                	</div>
                	<div class="control-group">
                		<?php echo $form->labelEx($model,'weight', array('class'=>'control-label')); ?>
                		<div class="controls">
                			<div class="input-append">
                                <?php echo $form->textField($model,'weight',array('size'=>5,'maxlength'=>5, 'class'=>'span1')); ?>
                                <span class="add-on">g</span>
                		    </div>
                			<?php echo $form->error($model,'weight'); ?>
                		</div>
                	</div>
                	<div class="control-group">
                		<?php echo $form->labelEx($model,'image', array('class'=>'control-label')); ?>
                		<div class="controls">
                			<?php echo $form->fileField($model,'image',array('class'=>'span4')); ?>
                			<?php echo $form->error($model,'image'); ?>
                		</div>
                	</div>
                
                	<div class="control-group">
                		<?php echo $form->labelEx($model,'description', array('class'=>'control-label')); ?>
                		<div class="controls">
                			<?php echo $form->textArea($model,'description',array('rows'=>15, 'cols'=>50, 'class'=>'span6')); ?>
                			<?php echo $form->error($model,'description'); ?>
                			<?php echo $this->text_formatting; ?>
                		</div>
                	</div>
                    <div class="control-group">
                		<?php echo $form->labelEx($model,'new', array('class'=>'control-label')); ?>
                		<div class="controls">
                			<?php echo $form->radioButtonList($model,'new',array('1'=>"Yes", '0'=>'No')); ?>
                			<?php echo $form->error($model,'new'); ?>
                		</div>
                	</div>	
                </div>
            </div>
        </div>
        <div class="accordion-group">
            <div class="accordion-heading">
                <h4><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#targets">Targets</a></h4>
            </div>
            <div id="targets" class="accordion-body collapse">
                <div class="accordion-inner">
                    <div class="control-group">
                		<?php echo $form->labelEx($model,'targetList', array('class'=>'control-label')); ?>
                		<div class="controls">
                			<?php echo $form->checkBoxList($model,'targetList',CHtml::listData(Target::model()->findAll(), 'id', 'name')); ?>
                			<?php echo $form->error($model,'targetList'); ?>
                		</div>
                	</div>
                </div>
            </div>
        </div>
        <div class="accordion-group">
            <div class="accordion-heading">
                <h4><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#categories">Categories</a></h4>
            </div>
            <div id="categories" class="accordion-body collapse">
                <div class="accordion-inner">
                	<div class="control-group">
                		<?php echo $form->labelEx($model,'categoryList', array('class'=>'control-label')); ?>
                		<div class="controls">
                			<?php echo $form->checkBoxList($model,'categoryList',CHtml::listData(Category::model()->findAll(), 'id', 'name')); ?>
                			<?php echo $form->error($model,'categoryList'); ?>
                		</div>
                	</div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); ?>
	</div>
    
<?php $this->endWidget(); ?>

</div><!-- form -->