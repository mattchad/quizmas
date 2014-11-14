<?php
class ResetForm extends CFormModel
{
	public $email_address;

	public function rules()
	{
		return array(
			// username and password are required
			array('email_address', 'required'),
			array('email_address', 'email'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'email_address'=>'Email address',
		);
	}
	
	public function sendPasswordReset()
	{
		$User = User::model()->findByAttributes(array('email_address' => $this->email_address));
		
		//We found a user with that email address, let's make a new hash and email them. 
		if($User !== null)
		{
    		$User->hash = Hash::random_key();
    		$User->save(false, array('hash'));
    		
    		$resetUrl = Yii::app()->request->getBaseUrl(true) . "/password-reset/" . $User->hash;
    		
    		$email_body = "Hello,

Someone, probably you, has requested a password reset for your account on " . Yii::app()->name . ". If it was you, click the link below to set a new password.

" . CHtml::link($resetUrl, $resetUrl) . "

If this wasn't you and you're not expecting this email you can just ignore it and your password will remain unchanged,

Thanks,
" . Yii::app()->name;
            $Email = new Email();
            $Email->addTo($this->email_address)->subject('Password reset on ' . Yii::app()->name)->messagePlain($email_body)->send();
		}
	}
}
