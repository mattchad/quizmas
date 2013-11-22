<div class="form">
<?php Yii::app()->clientScript->registerScript('prevent_change_loss', "
    var changed = false; 
    $('input').focus(function()
    {
        changed = true;
    }); 
    
    $('.nav-tabs').click(function()
    {
        if(changed)
        {
            if(!confirm('Are you sure you want view this event\'s options? Any changes to this event will be lost unless you press save.'))
            {
                return false;
            }
        }
    });
    ");?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'page-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype'=>'multipart/form-data', 'class'=>'form-horizontal'),
)); ?>
    <div class="accordion" id="accordion">
        <div class="accordion-group">
            <div class="accordion-heading">
                <h4><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#main_details">Main Details</a></h4>
            </div>
            <div id="main_details" class="accordion-body collapse in">
                <div class="accordion-inner">
                    <div class="control-group">
                		<?php echo $form->labelEx($model,'name', array('class'=>'control-label')); ?>
                		<div class="controls">
                			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100, 'class'=>'span4')); ?>
                			<?php echo $form->error($model,'name'); ?>
                		</div>
                	</div>
                	<div class="control-group character_count">
                		<?php echo $form->labelEx($model,'precis', array('class'=>'control-label')); ?>
                		<div class="controls">
                			<?php echo $form->textArea($model,'precis',array('rows'=>5, 'cols'=>50, 'class'=>'span6 count_input')); ?>
                			<?php echo $form->error($model,'precis'); ?>
                			<p class="count_number"><?php echo ($model->isNewRecord ? 0 : strlen(trim($model->precis)));?> characters</p>
                		</div>
                	</div>
                	
                	<div class="control-group">
                		<?php echo $form->labelEx($model,'description', array('class'=>'control-label')); ?>
                		<div class="controls">
                			<?php echo $form->textArea($model,'description',array('rows'=>20, 'cols'=>50, 'class'=>'span8')); ?>
                			<?php echo $form->error($model,'description'); ?>
                			<?php echo $this->text_formatting; ?>
                		</div>
                	</div>
                	<div class="control-group">
                		<?php echo $form->labelEx($model,'image', array('class'=>'control-label')); ?>
                		<div class="controls">
                			<?php echo $form->fileField($model,'image',array('class'=>'span4')); ?>
                			<?php echo $form->error($model,'image'); ?>
                		</div>
                	</div>
                	<div class="control-group checkboxlist">
                		<?php echo $form->labelEx($model,'images', array('class'=>'control-label')); ?>
                		<div class="controls">
                			<?php 
                				if(sizeof(CHtml::listData($model->current_images, 'id', 'filename')))
                				{
                					echo '<div class="current_page_images">';
                					echo '<p class="checkboxlist_help">Check below to delete</p>';
                					echo $form->checkBoxList($model, 'images', CHtml::listData($model->current_images, 'id', 'filename'));
                					echo '</div>';
                				}
                			?>
                			<?php 
                				$this->widget('CMultiFileUpload', array(
                					'name' => 'images',
                					'accept' => 'jpeg|jpg', // useful for verifying files
                					'duplicate' => 'Duplicate file!', // useful, i think
                					'denied' => 'Invalid file type', // useful, i think
                				));
                			?>
                		</div>
                	</div>
                	
                </div>
            </div>
        </div>
        <div class="accordion-group">
            <div class="accordion-heading">
                <h4><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#related">Related items</a></h4>
            </div>
            <div id="related" class="accordion-body collapse">
                <div class="accordion-inner">
                	<div class="control-group">
                	    <label class="control-label">Events</label>
                		<div class="controls">
                			<?php echo $form->checkBoxList($model,'eventList',CHtml::listData(Event::model()->other()->findAll(), 'id', 'name')); ?>
                		</div>
                	</div>
                	<div class="control-group">
                	    <label class="control-label">Courses</label>
                		<div class="controls">
                			<?php echo $form->checkBoxList($model,'courseList',CHtml::listData(Course::model()->findAll(), 'id', 'name')); ?>
                		</div>
                	</div>
                	<div class="control-group">
                	    <label class="control-label">Conferences</label>
                		<div class="controls">
                			<?php echo $form->checkBoxList($model,'conferenceList',CHtml::listData(Conference::model()->findAll(), 'id', 'name')); ?>
                		</div>
                	</div>
                	<div class="control-group">
                	    <label class="control-label">Publications</label>
                		<div class="controls">
                			<?php echo $form->checkBoxList($model,'publicationList',CHtml::listData(Publication::model()->findAll(), 'id', 'title')); ?>
                		</div>
                	</div>
                </div>
            </div>
        </div>

        <div class="accordion-group">
            <div class="accordion-heading">
                <h4><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#additional">Additional details</a></h4>
            </div>
            <div id="additional" class="accordion-body collapse">
                <div class="accordion-inner">
                	<div class="control-group">
                		<?php echo $form->labelEx($model,'persistent', array('class'=>'control-label tooltip-right', 'data-toggle' => 'tooltip', 'title'=>"A persistent event remains on event listings even if all of its sessions have passed.")); ?>
                		<div class="controls">
                			<?php echo $form->radioButtonList($model,'persistent',array('1'=>"Yes", '0'=>'No')); ?>
                			<?php echo $form->error($model,'persistent'); ?>
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