<?php

class PostageweightController extends AdController
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
			'PostageWeight'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$PostageWeight = new PostageWeight;

		if(isset($_POST['PostageWeight']))
		{
			$PostageWeight->attributes=$_POST['PostageWeight'];
			
			if($PostageWeight->validate())
			{
				$PostageWeight->save();
				$this->redirect(array('index'));
			}
		}
		
		$this->render('create',array(
			'PostageWeight'=>$PostageWeight,
		));
	}

	public function actionUpdate($id)
	{
		$PostageWeight = $this->loadModel($id);

		if(isset($_POST['PostageWeight']))
		{
			$PostageWeight->attributes=$_POST['PostageWeight'];
						
			if($PostageWeight->validate())
			{
				$PostageWeight->save();
				$this->redirect(array('index'));
			}
		}
		
		$this->render('update',array(
			'PostageWeight'=>$PostageWeight,
		));
	}

	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
        $this->redirect(array('index'));
	}

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('PostageWeight');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function loadModel($id)
	{
		$PostageWeight=PostageWeight::model()->findByPk($id);
		if($PostageWeight===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $PostageWeight;
	}
}
