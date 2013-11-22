<?php

class TargetController extends AdController
{
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(''),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','create','update', 'delete'),
				'roles'=>array('admin', 'editor'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionView($id)
	{
		$this->render('view',array(
			'Target'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$Target = new Target;

		if(isset($_POST['Target']))
		{
			$Target->attributes=$_POST['Target'];
			
			if($Target->validate())
			{
				$Target->save();
				$this->redirect(array('index'));
			}
		}
		
		$this->render('create',array(
			'Target'=>$Target,
		));
	}

	public function actionUpdate($id)
	{
		$Target = $this->loadModel($id);

		if(isset($_POST['Target']))
		{
			$Target->attributes=$_POST['Target'];
						
			if($Target->validate())
			{
				$Target->save();
				$this->redirect(array('index'));
			}
		}
		
		$this->render('update',array(
			'Target'=>$Target,
		));
	}

	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
		$this->redirect(array('index'));
	}

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Target');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function loadModel($id)
	{
		$model=Target::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
