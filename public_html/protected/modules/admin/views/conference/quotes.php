<div class="page-header">
	<h1><?php echo CHtml::encode($Event->name);?></h1>
</div>
<ul class="nav nav-tabs">
	<li><?php echo CHtml::link('Details', array('conference/update', 'id'=>$Event->id)); ?></li>
	<li><?php echo CHtml::link('Options', array('conference/options', 'id'=>$Event->id)); ?></li>
	<li class="active"><?php echo CHtml::link('Quotes', array('conference/quotes', 'id'=>$Event->id)); ?></li>
</ul>
<div class="row">
	<div class="span5">
		<?php $this->widget('zii.widgets.CListView', array(
			'dataProvider'=>$dataProvider,
			'itemView'=>'_quote',
			'summaryText' => '' 
		)); ?>
	</div>
	<div class="span6 offset1">
		<h2>Add Quote</h2>
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'session-form',
			'enableAjaxValidation'=>false,
			'htmlOptions' => array('class'=>'form-horizontal'),
		)); ?>
			<div class="control-group">
				<?php echo $form->labelEx($EventQuote,'author', array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($EventQuote,'author',array('size'=>10,'maxlength'=>50, 'class'=>'span3')); ?>
					<?php echo $form->error($EventQuote,'author'); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->labelEx($EventQuote,'quote', array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->textarea($EventQuote,'quote',array('rows'=>6, 'class'=>'span4')); ?>
					<?php echo $form->error($EventQuote,'quote'); ?>
				</div>
			</div>
			
			<div class="form-actions">
				<?php echo CHtml::submitButton('Add Quote', array('class'=>'btn btn-primary')); ?>
			</div>
		
		<?php $this->endWidget(); ?>
	</div>
</div>