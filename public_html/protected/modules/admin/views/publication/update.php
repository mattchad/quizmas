<div class="page-header">
	<h1><?php echo CHtml::encode($model->title);?></h1>
</div>
<ul class="nav nav-tabs">
	<li class="active"><?php echo CHtml::link('Details', array('publication/update', 'id'=>$model->id)); ?></li>
	<li><?php echo CHtml::link('Quotes', array('publication/quotes', 'id'=>$model->id)); ?></li>
</ul>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php if(strtotime($model->image)){ ?>
<div class="page-header">
	<h1>Image crops</h1>
</div>
<div class="form-horizontal">
    <div class="control-group">
        <?php echo CHtml::label('Listing Images','', array('class'=>'control-label')); ?>
    	<div class="controls">
    		<?php 
				echo '<p><img src="' . $model->blockImageUrl . '?time=' . time() . '" /></p>';
				echo '<p>' . CHtml::link('Edit image crop', array('image/crop', 'folder'=>'publication', 'id'=>$model->id, 'image_type'=>2), array('class'=>'btn')) . '</p>';
				echo '<p><img src="' . $model->thumbnailUrl . '?time=' . time() . '" /></p>';
				echo '<p>' . CHtml::link('Edit image crop', array('image/crop', 'folder'=>'publication', 'id'=>$model->id, 'image_type'=>1), array('class'=>'btn')) . '</p>';
    		?>
    	</div>
    </div>
</div>
<?php } ?>