<?php 
    /* $cipher = Hash::encrypt($data->text, 'password');
    $text = Hash::decrypt($cipher, 'password'); */
    if((bool)$data->encrypted)
    {
        $text = Hash::decrypt($data->text, (isset($_POST['password']) ? $_POST['password'] : '')); //Password needs replacing with some kind of variable
    }
    else
    {
        $text = $data->text;
    }

?>
<div class="panel panel-default question" data-id="<?php echo $data->id; ?>">
    <div class="panel-heading">
        <h4><span class="pull-right"><?php echo /* CHtml::link('Update', array('user/question', 'id'=>$data->id), array('class'=>'btn btn-primary btn-xs')) . ' ' .*/ CHtml::link('Delete', array('user/delete', 'id'=>$data->id), array('class'=>'btn btn-danger btn-xs', 'confirm'=>'Are you sure you want to delete this question?')); ?></span><span class="number"><?php echo $data->list_order; ?></span>. <?php echo (!is_null($text) ? $text : '<em>Question encrypted</em>') . ' (' . $data->value . ')'; ?></h4>
    </div>
</div>