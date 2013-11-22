<div class="page-header">
	<h1>Edit Image Crop</h1>
</div>
<p><img id="<?php echo $image_type == 1 ? 'jcrop_target' : 'jcrop_target_2'; ?>" src="<?php echo $Object->imageUrl; ?>?time=<?php echo time();?>" />
<div class="form-actions">
	<?php
		echo CHtml::beginForm('', 'post');
		if($image_type == 2)
		{ 
			echo CHtml::hiddenField('image[x]', $Object->image_block_x);
			echo CHtml::hiddenField('image[y]', $Object->image_block_y);
			echo CHtml::hiddenField('image[w]', $Object->image_block_w);
			echo CHtml::hiddenField('image[h]', $Object->image_block_h);
		}
		else
		{
			echo CHtml::hiddenField('image[x]', $Object->image_thumbnail_x);
			echo CHtml::hiddenField('image[y]', $Object->image_thumbnail_y);
			echo CHtml::hiddenField('image[w]', $Object->image_thumbnail_w);
			echo CHtml::hiddenField('image[h]', $Object->image_thumbnail_h);
		}
		echo CHtml::submitButton('Save Crop', array('class'=>'btn btn-primary')) . ' ';
		echo CHtml::link('Cancel', $return_route, array('class'=>'btn'));
		echo CHtml::endForm();
	?>
</div>