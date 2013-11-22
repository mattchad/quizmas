<div class="page-header">
	<h1><?php echo CHtml::encode($model->name);?></h1>
</div>
<ul class="nav nav-tabs">
	<li class="active"><?php echo CHtml::link('Details', array('event/update', 'id'=>$model->id)); ?></li>
	<li><?php echo CHtml::link('Options', array('event/options', 'id'=>$model->id)); ?></li>
	<li><?php echo CHtml::link('Quotes', array('event/quotes', 'id'=>$model->id)); ?></li>
</ul>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php if(strtotime($model->image)){ ?>
<div class="page-header">
	<h1>Image crops</h1>
</div>
<div class="form-horizontal">
    <div class="control-group">
        <?php echo CHtml::label('Listing Image','', array('class'=>'control-label')); ?>
    	<div class="controls">
    		<?php 
    			if(strlen($model->image))
    			{
					echo '<p><img src="' . $model->blockImageUrl . '?time=' . time() . '" /></p>';
					echo '<p>' . CHtml::link('Edit image crop', array('image/crop', 'folder'=>'event', 'id'=>$model->id, 'image_type'=>2), array('class'=>'btn')) . '</p>';
    			}
    		?>
    	</div>
    </div>
</div>
<?php } ?>