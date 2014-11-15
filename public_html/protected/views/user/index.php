<div class="page-header">
    <h1><?php echo CHtml::link('Add Question', array('user/question'), array('class'=>'btn btn-primary btn-lg pull-right')); ?>Your Questions</h1>
</div>
<?php echo CHtml::beginForm('', 'post', array('class'=>'form-inline')); ?>
<div class="form-group">
    <?php echo CHtml::passwordField('password', '', array('class'=>'form-control', 'placeholder'=>'Password')); ?>
</div>
<?php echo CHtml::submitButton('Show questions', array('class' => 'btn btn-primary')); ?>
<?php echo CHtml::endForm(); ?>
<?php 
    $this->widget('zii.widgets.CListView', array(
        'dataProvider' => new CActiveDataProvider('Question', array(
            'criteria'=>array(
                'condition'=>'user_id = :user_id',
                'params'=>array('user_id'=>Yii::app()->user->id),
            ),
            'pagination'=>array(
                'pageSize'=>200,
            ),
        )),
        'itemView'=>'_question',
        'htmlOptions'=>array(
            'id'=>'question_list',
        ),
    ));
?>