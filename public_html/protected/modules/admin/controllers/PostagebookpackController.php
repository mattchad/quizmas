<?php

class PostagebookpackController extends AdController
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
			'PostageBookpack'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$PostageBookpack = new PostageBookpack;

		if(isset($_POST['PostageBookpack']))
		{
			$PostageBookpack->attributes=$_POST['PostageBookpack'];
			
			if($PostageBookpack->validate())
			{
				$PostageBookpack->save();
				$this->redirect(array('index'));
			}
		}
		
		$this->render('create',array(
			'PostageBookpack'=>$PostageBookpack,
		));
	}

	public function actionUpdate($id)
	{
		$PostageBookpack = $this->loadModel($id);

		if(isset($_POST['PostageBookpack']))
		{
			$PostageBookpack->attributes=$_POST['PostageBookpack'];
						
			if($PostageBookpack->validate())
			{
				$PostageBookpack->save();
				$this->redirect(array('index'));
			}
		}
		
		$this->render('update',array(
			'PostageBookpack'=>$PostageBookpack,
		));
	}

	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
        $this->redirect(array('index'));
	}

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('PostageBookpack', array('pagination'=>false));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function loadModel($id)
	{
		$PostageBookpack=PostageBookpack::model()->findByPk($id);
		if($PostageBookpack===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $PostageBookpack;
	}
}
