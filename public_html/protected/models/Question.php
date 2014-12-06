<?php

class Question extends CActiveRecord
{	
    public $password;
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'question';
	}

	public function rules()
	{
		return array(
			array('text', 'length', 'min'=>3, 'max'=>100),
			
			array('value', 'numerical', 'min'=>1, 'max'=>100),
			
			array('list_order', 'numerical', 'integerOnly'=>true, 'min'=>1),

			array('password', 'matchesUserPassword'),
			
			array('text, value, list_order, password', 'required'),
			
			array('encrypted', 'safe'),
		);
	}
	
	public function matchesUserPassword($attribute,$params)
	{
    	if(!Hash::validate_password($this->password, Yii::app()->user->password))
    	{
        	$this->addError($attribute, 'This is not your password');
        	return false;
    	}
	}

	public function relations()
	{
		return array(
    		'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'text' => 'Text',
			'value' => 'Value',
			'list_order' => 'Order',
			'password' => 'Your Password',
			'encrypted' => 'Encryption status',
		);
	}
	
	public function defaultScope()
    {
        return array(
            'order' => 'list_order ASC',
        );      
 
    }
    
    public function beforeSave()
    {
        if($this->isNewRecord)
    	{
        	//Go and find the last question for this user and increment the list_order by one. 
        	
        	$previousQueston = Question::model()->findByAttributes(array('user_id'=>Yii::app()->user->id), array('order'=>'list_order DESC'));
        	if(!is_null($previousQueston))
        	{
        	    $this->list_order = $previousQueston->list_order + 1;
        	}
        	else
        	{
        	    $this->list_order = 1;
        	}
    	}
    	
    	if(!$this->encrypted)
    	{
        	$this->text = Hash::encrypt($this->text, $this->password);
        	$this->encrypted = 1;
    	}
    	
    	return parent::beforeSave();
    }
    
    public static function nextQuestion($password = null)
    {
        //Loop through the users in round order
        foreach(User::model()->findAll() as $Player)
        {
            //Go and find all the incomplete quetions for this player.
            $IncompleteQuestions = $Player->questions(array('condition'=>'complete = 0'));
            
            //If there's incomplete questions, we return the first as our next question.
            if(sizeof($IncompleteQuestions))
            {
                if(!is_null($password))
                {
                    $IncompleteQuestions[0]->text = Hash::decrypt($IncompleteQuestions[0]->text, $password);
                }
                return $IncompleteQuestions[0];
            }
        }
        return null; //We don't have a next question.
    }
}