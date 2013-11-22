<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $email_address
 * @property string $password
 */
class User extends CActiveRecord
{	
	const ROLE_USER = 10;
	const ROLE_EDITOR = 20;
	const ROLE_ADMIN = 30;
	
	public $password_repeat;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
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
			
			array('hash, password_repeat, role, address_id', 'safe'),
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
			'address' => array(self::BELONGS_TO, 'Address', 'address_id'),
			'attendances' => array(self::HAS_MANY, 'Attendee', 'user_id'),
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
	
	public function beforeSave()
	{
		$this->password = sha1($this->password);
		foreach(Attendee::model()->findAllByAttributes(array('email_address'=>$this->email_address), array('condition'=>'user_id IS NULL')) as $Attendee)
		{
            $Attendee->user_id = $this->id;
            $Attendee->save(false);
		}
		return true;
	}
	
	public function sendEmailVerification()
	{
		$email_body = "Hello,\n\r";
		$email_body .= "Thank you for registering on the CLPE website. To complete your registration you need to verify your email address, click the link below to do this.\n\r";
		$email_body .= Yii::app()->request->getBaseUrl(true) . "/user/verify/" . $this->hash . "\n\r";
		$email_body .= "Thanks,\n\r";
		$email_body .= "CLPE";
		
		sendEmail("CLPE Email verification", $email_body, $this->email_address);
	}
}