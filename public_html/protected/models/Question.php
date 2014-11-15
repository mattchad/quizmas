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
		return array();
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
        	$this->list_order = Question::model()->findByAttributes(array('user_id'=>Yii::app()->user->id), array('order'=>'list_order DESC'))->list_order + 1;
    	}
    	
    	if(!$this->encrypted)
    	{
        	$this->text = Hash::encrypt($this->text, $this->password);
        	$this->encrypted = 1;
    	}
    	
    	return parent::beforeSave();
    }
}