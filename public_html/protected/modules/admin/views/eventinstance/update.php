<div class="page-header">
	<h1><?php echo CHtml::encode($EventInstance->event->name);?></h1>
</div>
<ul class="nav nav-tabs">
    <?php 
    switch($EventInstance->event->type)
    {
        case Event::TYPE_COURSE:
        {
            ?>
        	<li><?php echo CHtml::link('Details', array('course/update', 'id'=>$EventInstance->event->id)); ?></li>
        	<li><?php echo CHtml::link('Options', array('course/options', 'id'=>$EventInstance->event->id)); ?></li>
        	<li><?php echo CHtml::link('Quotes', array('course/quotes', 'id'=>$EventInstance->event->id)); ?></li>
            <?php
            break;
        }    
        case Event::TYPE_CONFERENCE:
        {
            ?>
        	<li><?php echo CHtml::link('Details', array('conference/update', 'id'=>$EventInstance->event->id)); ?></li>
        	<li><?php echo CHtml::link('Options', array('conference/options', 'id'=>$EventInstance->event->id)); ?></li>
        	<li><?php echo CHtml::link('Quotes', array('conference/quotes', 'id'=>$EventInstance->event->id)); ?></li>
            <?php
            break;
        }    
        default:
        {
            ?>
        	<li><?php echo CHtml::link('Details', array('event/update', 'id'=>$EventInstance->event->id)); ?></li>
        	<li><?php echo CHtml::link('Options', array('event/options', 'id'=>$EventInstance->event->id)); ?></li>
        	<li><?php echo CHtml::link('Quotes', array('event/quotes', 'id'=>$EventInstance->event->id)); ?></li>
            <?php
            break;
        }    
    }
    ?>
	<li class="active"><?php echo CHtml::link('Option Details', array('eventinstance/update', 'id'=>$EventInstance->id)); ?></li>
</ul>

<div class="row">
	<div class="span5">
	    <h2>Add Session</h2>
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
				<?php echo CHtml::submitButton('Add Session', array('class'=>'btn btn-primary')); ?>
			</div>
		
		<?php $this->endWidget(); ?>
		<h2>Sessions</h2>
		<ul>
		<?php 
			foreach($EventInstance->sessions as $session)
			{
				echo '<li>' . date('l, jS F Y - H:i', $session->start_time) . ' to ' . date('H:i', $session->end_time) . ' ' . (sizeof($EventInstance->sessions) > 1 ? CHtml::link("Delete", array('eventsession/delete', 'id'=>$session->id), array("class"=>'btn btn-mini btn-danger')) : "") . '</li>';
			}
		?>
		</ul>
	</div>
	<div class="span7">
	    <h2>Attendees <?php echo CHtml::link('Download Attendees', array('eventinstance/attendees', 'id'=>$EventInstance->id), array('class'=>'btn btn-small pull-right'));?></h2>
		<?php 
    		$this->widget('zii.widgets.grid.CGridView', array(
                'dataProvider' =>$attendeeProvider,
                'columns'=>array(
                    array(            // display 'create_time' using an expression
                        'name'=>'first_name',
                        'header'=>'First name',
                    ),
                    array(            // display 'create_time' using an expression
                        'name'=>'last_name',
                        'header'=>'Last name',
                    ),
                    array(            // display 'create_time' using an expression
                        'name'=>'email_address',
                        'header'=>'Email address',
                        'type'=>'raw',
                        'value'=>'CHtml::link($data->email_address, "mailto:" . $data->email_address)',
                    ),
                    array(            // display 'create_time' using an expression
                        'name'=>'order.paid',
                        'header'=>'Status',
                        'type'=>'raw',
                        'value'=>'CHtml::link(($data->order->paid ? "Confirmed": "Unpaid"), array("order/update", "id"=>$data->order->id))',
                    ),
                ),
                'itemsCssClass' => 'table table-bordered',
            ));
		?>
	</div>
</div>