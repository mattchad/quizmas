<?php

class User extends CActiveRecord
{	
	public $password_repeat;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name, last_name', 'length', 'min'=>3, 'max'=>50),
			array('password', 'length', 'max'=>20),
			array('password', 'compare'),
			
			array('first_name, last_name, email_address', 'required'),
			array('password', 'required'),
			
			array('email_address', 'email'),
			array('email_address', 'unique', 'message'=>'The email address {value} is already registered'),
			
			array('hash, password_repeat, points, round_points sound_file, image_file', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, email_address, password', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
    		'questions' => array(self::HAS_MANY, 'Question', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email_address' => 'Email Address',
			'password_repeat' => 'Confirm Password',
			'first_name' => 'First name',
			'last_name' => 'Last name',
			'fullname' => 'Full name',
			
		);
	}
	
	public function getFullname()
	{
    	return $this->first_name . ' ' . $this->last_name;
	}
	
	public function defaultScope()
    {
        //Should always be in round order, this is relied upon in serveral places
        return array(
            'order' => 'round_order ASC, id ASC',
        );      
    }
}