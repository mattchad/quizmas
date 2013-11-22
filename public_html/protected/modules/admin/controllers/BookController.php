<?php

class BookController extends AdController
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
		$model=new Book;
		$model->start_date = date('d/m/Y');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['Book']))
		{
			$model->attributes=$_POST['Book'];
			
			if(isset($_POST['start_date']))
			{
				$model->start_date = $_POST['start_date'];
			}
			
			$uploaded_image = CUploadedFile::getInstance($model,'image');
			if($uploaded_image !== null)
			{
				$model->uploaded_image = $uploaded_image;
				$model->image = $uploaded_image;
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
		if($model->start_date == '0000-00-00')
		{
    		$model->start_date = date('Y-m-d');
		}
		
		$model->start_date = date('d/m/Y', strtotime($model->start_date));

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Book']))
		{
			$model->attributes=$_POST['Book'];
			
			if(isset($_POST['start_date']))
			{
				$model->start_date = $_POST['start_date'];
			}
			
			$uploaded_image = CUploadedFile::getInstance($model,'image');
			if($uploaded_image !== null)
			{
				$model->uploaded_image = $uploaded_image;
				$model->image = $uploaded_image;
			}
			
			if($model->validate())
			{
			    if($model->save(false))
			    {
                    $this->redirect(array('update','id'=>$model->id));
				}
			}
		}
		
		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(array('index'));
	}

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Book', array(
		    'criteria'=>array(
		        'order'=>'start_date DESC'
		    ),
        ));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function loadModel($id)
	{
		$model=Book::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='book-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
