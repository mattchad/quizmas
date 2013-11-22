<?php

class CategoryController extends AdController
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
			'Category'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$Category = new Category;

		if(isset($_POST['Category']))
		{
			$Category->attributes=$_POST['Category'];
			
			if($Category->validate())
			{
				$Category->save();
				$this->redirect(array('index'));
			}
		}
		
		$this->render('create',array(
			'Category'=>$Category,
		));
	}

	public function actionUpdate($id)
	{
		$Category = $this->loadModel($id);

		if(isset($_POST['Category']))
		{
			$Category->attributes=$_POST['Category'];
						
			if($Category->validate())
			{
				$Category->save();
				$this->redirect(array('index'));
			}
		}
		
		$this->render('update',array(
			'Category'=>$Category,
		));
	}

	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
		$this->redirect(array('index'));
	}

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Category');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function loadModel($id)
	{
		$model=Category::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
