<?php

class NewsController extends AdController
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(''),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('view','index','create','update', 'delete'),
				'roles'=>array('admin', 'editor'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new News;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['News']))
		{
			$model->attributes=$_POST['News'];
			$model->time = date("H:i");
			$model->date = date("d/m/Y");
			
			$uploaded_image = CUploadedFile::getInstance($model,'image');
			if($uploaded_image !== null)
			{
				$model->image = $uploaded_image;
				$model->uploaded_image = $uploaded_image;
			}
			
			if($model->validate())
			{
				if($model->save())
    			{
    				//Save images
    				$images = CUploadedFile::getInstancesByName('images');
    				
    				if(isset($images) && sizeof($images))
    				{
    					foreach($images as $single_image)
    					{
    						$Image = new NewsImage;
    						$Image->news_id = $model->id;
    						$Image->uploaded_image = $single_image;
                            $Image->save();
    					}
    				}
    				
    				//Save downloads
    				$downloads = CUploadedFile::getInstancesByName('downloads');
    				
    				if(isset($downloads) && sizeof($downloads))
    				{
    					foreach($downloads as $single_download)
    					{
    						$Download = new NewsDownload;
    						$Download->news_id = $model->id;
    						$Download->uploaded_file = $single_download;
                            $Download->save();
    					}
    				}
    				$this->redirect(array('update','id'=>$model->id));
    			}
			}
		}
		
		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$model->time = date("H:i", $model->date);
		$model->date = date("d/m/Y", $model->date);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['News']))
		{
			$model->attributes=$_POST['News'];
			if(isset($_POST['post-date']))
			{
				$model->date = $_POST['post-date'];
			}
			
			$uploaded_image = CUploadedFile::getInstance($model,'image');
			if($uploaded_image !== null)
			{
				$model->image = $uploaded_image;
				$model->uploaded_image = $uploaded_image;
			}
			
			if($model->validate())
			{
			    if(isset($_POST['News']['images']) && is_array($_POST['News']['images']))
    			{
    				foreach($_POST['News']['images'] as $index => $image)
    				{
    					$Image = NewsImage::model()->findByPk($image);
    					if($Image !== null)
    					{
    						$Image->delete();
    					}
    				}
    			}
    			
    			if(isset($_POST['News']['downloads']) && is_array($_POST['News']['downloads']))
    			{
    				foreach($_POST['News']['downloads'] as $index => $download)
    				{
    					$Download = NewsDownload::model()->findByPk($download);
    					if($Download !== null)
    					{
    						$Download->delete();
    					}
    				}
    			}
			    if($model->save())
    			{
    				//Save images
    				$images = CUploadedFile::getInstancesByName('images');
    				
    				if(isset($images) && sizeof($images))
    				{
    					foreach($images as $single_image)
    					{
    						$Image = new NewsImage;
    						$Image->news_id = $model->id;
    						$Image->uploaded_image = $single_image;
                            $Image->save();
    					}
    				}
    				
    				//Save downloads
    				$downloads = CUploadedFile::getInstancesByName('downloads');
    				
    				if(isset($downloads) && sizeof($downloads))
    				{
    					foreach($downloads as $single_download)
    					{
    						$Download = new NewsDownload;
    						$Download->news_id = $model->id;
    						$Download->uploaded_file = $single_download;
                            $Download->save();
    					}
    				}
    				$this->redirect(array('update','id'=>$model->id));
    			}
			}
		}
		
		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('News');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function loadModel($id)
	{
		$model=News::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='news-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
