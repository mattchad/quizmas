<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $id;
	
	public function authenticate()
	{
		$User = User::model()->findByAttributes(array('email_address'=>$this->username));
		
		if ($User===null) // No user found!
		{
			$this->errorCode = self::ERROR_USERNAME_INVALID; // ERROR_USERNAME_INVALID = 1
		}
		else if(!Hash::validate_password($this->password, $User->password)) // Invalid password!
		{
			//$this->errorCode=self::ERROR_PASSWORD_INVALID; // ERROR_PASSWORD_INVALID = 2
			$this->errorCode = self::ERROR_USERNAME_INVALID; // ERROR_USERNAME_INVALID = 1
		}
		else // Okay!
		{ 
			$this->errorCode = self::ERROR_NONE; // ERROR_NONE = 0
			
			$this->id = $User->id;
		}
		
		return $this->errorCode;
	}
	
	public function getId()
	{
		return $this->id;
	}
}