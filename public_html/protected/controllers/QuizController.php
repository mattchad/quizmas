<?php

class QuizController extends Controller
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
				'actions'=>array('buzzer', 'scoreboard', 'quizmaster'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionBuzzer()
	{
		$this->layout = 'main';
		$this->pageTitle = 'Buzzer';
		Yii::app()->clientScript->registerScriptFile('/_js/buzzer.js');
		$this->render('buzzer');
	}
	
	public function actionScoreboard()
	{
		$this->layout = 'main';
		
		Yii::app()->clientScript->registerScriptFile('/_js/scoreboard.js');
		
		$Players = User::model()->findAll(array('order'=>'last_name ASC'));
		
		$this->render('scoreboard', array('Players'=>$Players));
	}
	
	public function actionQuizmaster()
	{
		$this->layout = 'main';
		$this->pageTitle = 'Quizmaster';
		Yii::app()->clientScript->registerScriptFile('/_js/quizmaster.js');
		
		$Players = User::model()->findAll(array('order'=>'last_name ASC'));
		
		$this->render('quizmaster', array('Players'=>$Players));
	}
}