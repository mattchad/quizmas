<?php

class User extends CActiveRecord
{	
	const ROLE_USER = 10;
	const ROLE_ADMIN = 30;
	
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
			array('position', 'length', 'max'=>50),
			array('password', 'length', 'max'=>20, 'except'=>'edit_user'),
			array('password','ext.SPasswordValidator', 'up' => 0, 'low' => 1, 'digit'=>1, 'spec'=>0, 'min' => 6, 'max' => 21, 'except'=>'edit_user'),
			array('password', 'compare', 'except'=>'edit_user'),
			
			array('first_name, last_name, position, email_address', 'required'),
			array('password', 'required', 'except'=>'edit_user'),
			
			array('email_address', 'email'),
			array('email_address', 'unique', 'message'=>'The email address {value} is already registered'),
			
			array('hash, password_repeat, score', 'safe'),
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
		return array();
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
}