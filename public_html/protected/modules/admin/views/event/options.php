<div class="page-header">
	<h1><?php echo CHtml::encode($Event->name);?></h1>
</div>
<ul class="nav nav-tabs">
	<li><?php echo CHtml::link('Details', array('event/update', 'id'=>$Event->id)); ?></li>
	<li class="active"><?php echo CHtml::link('Options', array('event/options', 'id'=>$Event->id)); ?></li>
	<li><?php echo CHtml::link('Quotes', array('event/quotes', 'id'=>$Event->id)); ?></li>
</ul>
<div class="row">
	<div class="span5">
		<?php $this->widget('zii.widgets.CListView', array(
			'dataProvider'=>$dataProvider,
			'itemView'=>'_option',
			'summaryText' => '' 
		)); ?>
	</div>
	<div class="span6 offset1">
		<h2>Add option</h2>
		<p>Please provide the start and end time of a session in this option.</p>
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'session-form',
			'enableAjaxValidation'=>false,
			'htmlOptions' => array('class'=>'form-horizontal'),
		)); ?>
			<div class="control-group">
				<?php echo $form->labelEx($EventSession,'date', array('class'=>'control-label')); ?>
				<div class="controls">
					<?php 
						$this->widget('zii.widgets.jui.CJuiDatePicker', array(
							'name'=>'event-date',
							'value' => $EventSession->date,
							'htmlOptions'=>array(
								'size'=>10,
								'maxlength'=>10, 
								'class'=>'span2'
							),
							'options' => array(
								'dateFormat' => 'dd/mm/yy',
							)
						));
					?>
					<?php echo $form->error($EventSession,'date'); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->labelEx($EventSession,'s_time', array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($EventSession,'s_time',array('size'=>10,'maxlength'=>5, 'class'=>'span1')); ?>
					<?php echo $form->error($EventSession,'s_time'); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->labelEx($EventSession,'e_time', array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($EventSession,'e_time',array('size'=>60,'maxlength'=>5, 'class'=>'span1')); ?>
					<?php echo $form->error($EventSession,'e_time'); ?>
				</div>
			</div>
			
			<div class="form-actions">
				<?php echo CHtml::submitButton('Add Option', array('class'=>'btn btn-primary')); ?>
			</div>
		
		<?php $this->endWidget(); ?>
	</div>
</div>