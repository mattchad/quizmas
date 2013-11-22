<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class ResetForm extends CFormModel
{
	public $email_address;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('email_address', 'required'),
			array('email_address', 'email'),
			array('email_address', 'verifyUserExists'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'email_address'=>'Email address',
		);
	}
	
	public function verifyUserExists($attribute,$params)
	{
		$user = User::model()->findByAttributes(array('email_address'=>$this->email_address));
		
		if ($user === null) // No user found!
		{
			$this->addError('email_address','No user account was found for this email address.');
		}
	}
	
	public function sendPasswordReset()
	{
		$user = User::model()->findByAttributes(array('email_address'=>$this->email_address));
		$user->hash = sha1(uniqid());
		if($user->save(false))
		{
			$email_body = "Hello,\n\r";
			$email_body .= "Someone, probably you, has requested a password reset for your account on Emailer. If it was you, click the link below to choose a new password.\n\r";
			$email_body .= Yii::app()->request->getBaseUrl(true) . "/user/reset/" . $user->hash . "\n\r";
			$email_body .= "If this wasn't you and you're not expecting this email you can just ignore it and your password will remain unchanged,\n\r";
			$email_body .= "Thanks,\n\r";
			$email_body .= "Modlia";
			
			sendEmail("Password reset", $email_body, $user->email_address);
		}
	}
}
