<?php

class SlideController extends AdController
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
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$model=new Slide;
		if(isset($_POST['Slide']))
		{
			$model->attributes=$_POST['Slide'];
			
			$model->uploaded_image = CUploadedFile::getInstance($model,'uploaded_image');
			
			if($model->uploaded_image != null)
			{
    			$model->image = true;
			}
						
			if($model->validate())
			{
				$model->save();
				$this->redirect(array('update','id'=>$model->id));
			}
		}
		
		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		if(isset($_POST['Slide']))
		{
			$model->attributes=$_POST['Slide'];
			
			$model->uploaded_image = CUploadedFile::getInstance($model,'uploaded_image');
			
			if($model->validate())
			{
				$model->save();
				$this->redirect(array('update','id'=>$model->id));
			}
		}
		
		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
		
		$this->redirect(array('index'));
	}

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Slide');
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function loadModel($id)
	{
		$model=Slide::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
