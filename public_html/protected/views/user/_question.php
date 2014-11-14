<div class="panel panel-default question" data-id="<?php echo $data->id; ?>">
    <div class="panel-heading">
        <h4><span class="number"><?php echo $data->list_order; ?></span>. <?php echo $data->text . ' (' . $data->value . ')'; ?> <span class="pull-right"><?php echo CHtml::link('Update', array('user/question', 'id'=>$data->id), array('class'=>'btn btn-primary btn-xs')) . ' ' . CHtml::link('Delete', array('user/delete', 'id'=>$data->id), array('class'=>'btn btn-danger btn-xs', 'confirm'=>'Are you sure you want to delete this question?')); ?></span></h4>
    </div>
</div>