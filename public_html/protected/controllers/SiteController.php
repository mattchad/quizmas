<?php

class SiteController extends Controller
{
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('login', 'error', 'logout', 'reset'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	public function actionLogin()
	{
	    $this->pageTitle = 'Login';
	    
		if(!Yii::app()->user->isGuest)
		{
			//This visitor is already logged in. 
			$this->redirect(array("site/index"));
		}
		else
		{
    		//Before we login, let's make sure everyone has a password;
    		foreach(User::model()->findAll(array('condition'=>"password = ''")) as $User)
    		{
        		if(!strlen($User->password))
        		{
            		$User->password = Hash::create_hash('password');
            		$User->save(false);
        		}
    		}
    		
			$LoginForm = new LoginForm;
	
			// collect user input data
			if(isset($_POST['LoginForm']))
			{
				$LoginForm->attributes = $_POST['LoginForm'];
				
				if($LoginForm->validate()) // We're doing the logging in here too
				{
					// Validate() validates that the email address and password format are correct, in turn firing authenticate() in the model
					$this->redirect(Yii::app()->user->returnUrl);
				}
			}
			// display the login form
			$this->render('login',array('LoginForm'=>$LoginForm));
		}
	}
	
	public function actionReset()
	{
	    $this->pageTitle = 'Reset Password';
	    
		$ResetForm = new ResetForm;
		
		if(isset($_POST['ResetForm']))
		{
			$ResetForm->attributes = $_POST['ResetForm'];
			
			if($ResetForm->validate())
			{
				$ResetForm->sendPasswordReset();
				
				Yii::app()->user->setFlash('success' ,'An email has been sent to your email address with a password reset link. ');
				
				$this->redirect(array('site/login'));
			}
		}
		
		$this->render('reset', array('ResetForm'=>$ResetForm));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}