<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $email_address;
	public $password;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('email_address, password', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			array('email_address', 'email'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'email_address'=>'Email address',
			'rememberMe'=>'Remember me next time',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->email_address,$this->password);
			$this->_identity->authenticate();
			
			switch($this->_identity->errorCode)
			{
				case UserIdentity::ERROR_NONE:
				{
					$duration = $this->rememberMe ? 3600*24*30 : 0; // 30 days
					Yii::app()->user->login($this->_identity, $duration);
					break;
				}
				case UserIdentity::ERROR_USERNAME_INVALID:
				{
					$this->addError('email_address','Unable to find a verified account with these details.');
					break;
				}
				case UserIdentity::ERROR_PASSWORD_INVALID:
				{
					$this->addError('password','Password is incorrect.');
					break;
				}
				default:
				{
					$this->addError('email_address','An unknown error occurred.');
					break;
				}
			}
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	/* 
		We're doing this through validate() instead!
		
		public function login()
		{
			if($this->_identity===null)
			{
				$this->_identity=new UserIdentity($this->email_address,$this->password);
				$this->_identity->authenticate();
			}
			if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
			{
				$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
				Yii::app()->user->login($this->_identity,$duration);
				return true;
			}
			else
				return false;
		}
	*/
}
