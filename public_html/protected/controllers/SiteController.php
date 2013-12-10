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
				'actions'=>array('index', 'buzzer', 'scoreboard', 'quizmaster'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
		
	public function actionIndex()
	{
        $this->redirect(array('site/buzzer'));

		//$this->render('index');
	}
	
	public function actionBuzzer()
	{
		$this->pageTitle = 'Buzzer';
		Yii::app()->clientScript->registerScriptFile('/_js/buzzer.js');
		$this->render('buzzer');
	}
	
	public function actionScoreboard()
	{
		Yii::app()->clientScript->registerScriptFile('/_js/scoreboard.js');
		
		$Players = User::model()->findAll(array('order'=>'last_name ASC'));
		
		$this->render('scoreboard', array('Players'=>$Players));
	}
	
	public function actionQuizmaster()
	{
		$this->pageTitle = 'Quizmaster';
		Yii::app()->clientScript->registerScriptFile('/_js/quizmaster.js');
		
		$Players = User::model()->findAll(array('order'=>'last_name ASC'));
		
		$this->render('quizmaster', array('Players'=>$Players));
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
	    $this->pageTitle = 'Login | ' . $this->pageTitle;
		if(!Yii::app()->user->isGuest)
		{
			$this->redirect(array("site/index"));
		}
		else
		{
			$model=new LoginForm;
	
			// if it is ajax validation request
			if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
			{
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}
	
			// collect user input data
			if(isset($_POST['LoginForm']))
			{
				$model->attributes=$_POST['LoginForm'];
				// validate user input and redirect to the previous page if valid
				
				//if($model->validate() && $model->login())
				
				if($model->validate()) // We're doing the logging in here too
				{
					/* 
						Validate() validates that the email address and password format are correct, in turn firing authenticate() in the model
					*/
					$this->redirect(Yii::app()->user->returnUrl);
				}
			}
			// display the login form
			$this->render('login',array('model'=>$model));
		}
	}
	
	public function actionReset()
	{
	    $this->pageTitle = 'Reset Password | ' . $this->pageTitle;
		$model=new ResetForm;
		
		$reset_sent = false;
		
		if(isset($_POST['ResetForm']))
		{
			$model->attributes=$_POST['ResetForm'];
			
			if($model->validate())
			{
				$model->sendPasswordReset();
				$reset_sent = true;
			}
		}
		
		$this->render('reset', array('model'=>$model, 'reset_sent' => $reset_sent));
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