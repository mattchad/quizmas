<?php

class PublicationController extends AdController
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
				'actions'=>array('index','create','update', 'delete', 'quotes'),
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
		$model=new Publication;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['Publication']))
		{
			$model->attributes=$_POST['Publication'];
			
			$uploaded_image = CUploadedFile::getInstance($model,'image');
			if($uploaded_image !== null)
			{
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Publication']))
		{
			$model->attributes=$_POST['Publication'];
			
			$uploaded_image = CUploadedFile::getInstance($model,'image');
			if($uploaded_image !== null)
			{
				$model->image = $uploaded_image;
			}
			
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

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(array('index'));
	}

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Publication');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function actionQuotes($id)
	{
		$Publication = $this->loadModel($id);
		$PublicationQuote = new PublicationQuote;
		$PublicationQuote->publication_id = $id;
		
		$dataProvider =  new CArrayDataProvider('PublicationQuote');
        $dataProvider->setData($Publication->quotes);
        
        if(isset($_POST['PublicationQuote']))
		{
			$PublicationQuote->attributes = $_POST['PublicationQuote'];
			
			if($PublicationQuote->validate())
			{
				$PublicationQuote->save();
				$this->redirect(array('quotes','id' => $id));
			}
		}
				
		$this->render('quotes',array(
			'dataProvider'=>$dataProvider,
			'Publication'=>$Publication,
			'PublicationQuote'=>$PublicationQuote,
		));
	}

	public function loadModel($id)
	{
		$model=Publication::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='publication-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
