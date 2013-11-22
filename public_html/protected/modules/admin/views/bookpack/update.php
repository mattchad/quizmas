<div class="page-header">
	<h1>Edit Book Pack</h1>
</div>

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
				echo '<p><img src="' . $model->thumbnailUrl . '?time=' . time() . '" /></p>';
				echo '<p>' . CHtml::link('Edit image crop', array('image/crop', 'folder'=>'bookpack', 'id'=>$model->id, 'image_type'=>1), array('class'=>'btn')) . '</p>';
    		?>
    	</div>
    </div>
</div>
<?php } ?>