<div class="page-header">
    <h1>Hello <?php echo $User->first_name; ?> <?php echo CHtml::link('Add Question', array('user/question'), array('class'=>'btn btn-primary btn-lg pull-right')); ?></h1>
</div>
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