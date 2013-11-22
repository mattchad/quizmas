<?php

class PageController extends AdController
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
		$model=new Page;
		
		$model->status = Page::STATUS_OFFLINE;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['Page']))
		{
			$model->attributes=$_POST['Page'];
			if($model->save())
			{
				//Save images
				$images = CUploadedFile::getInstancesByName('images');
				
				if(isset($images) && sizeof($images))
				{
					foreach($images as $single_image)
					{
						$Image = new PageImage;
						$Image->page_id = $model->id;
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
						$Download = new PageDownload;
						$Download->page_id = $model->id;
						$Download->uploaded_file = $single_download;
                        $Download->save();
					}
				}
				$this->redirect(array('update','id'=>$model->id));
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Page']))
		{
			$model->attributes=$_POST['Page'];
			if(isset($_POST['Page']['images']) && is_array($_POST['Page']['images']))
			{
				foreach($_POST['Page']['images'] as $index => $image)
				{
					$Image = PageImage::model()->findByPk($image);
					if($Image !== null)
					{
						$Image->delete();
					}
				}
			}
			if(isset($_POST['Page']['downloads']) && is_array($_POST['Page']['downloads']))
			{
				foreach($_POST['Page']['downloads'] as $index => $download)
				{
					$Download = PageDownload::model()->findByPk($download);
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
						$Image = new PageImage;
						$Image->page_id = $model->id;
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
						$Download = new PageDownload;
						$Download->page_id = $model->id;
						$Download->uploaded_file = $single_download;
                        $Download->save();
					}
				}
				$this->redirect(array('update','id'=>$model->id));
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
		$Page = $this->loadModel($id);
		
		if(!sizeof($Page->nav))
		{
    		$Page->delete();
    		$this->redirect(array('index'));
		}
		else
		{
    		throw new CHttpException(404,'The requested page does not exist.');
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Page', array('pagination'=>false));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Page('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Page']))
			$model->attributes=$_GET['Page'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Page the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Page::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Page $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='page-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
