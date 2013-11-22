<?php

class EventController extends AdController
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
				'actions'=>array('view','index','create','update', 'delete', 'options', 'quotes'),
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
		$model=new Event;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['Event']))
		{
			$model->attributes=$_POST['Event'];
			
			$uploaded_image = CUploadedFile::getInstance($model,'image');
			if($uploaded_image !== null)
			{
				$model->uploaded_image = $uploaded_image;
				$model->image = $uploaded_image;
			}
			
			if($model->validate())
			{
				$model->save();
				
				//Save images
				$images = CUploadedFile::getInstancesByName('images');
				if(isset($images) && sizeof($images))
				{
					foreach($images as $single_image)
					{	
						$Image = new EventImage;
						$Image->event_id = $model->id;
						$Image->uploaded_image = $single_image;
						$Image->save();
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

		//I'm not able to do this 'afterFind' like categories and targets. Apache crashes.
        $model->eventList = $model->courseList = $model->conferenceList = CHtml::listData($model->related_events, 'id', 'id');

		if(isset($_POST['Event']))
		{
			$model->attributes=$_POST['Event'];
			
			$uploaded_image = CUploadedFile::getInstance($model,'image');
			if($uploaded_image !== null)
			{
				$model->uploaded_image = $uploaded_image;
				$model->image = $uploaded_image;
			}
			
			if(isset($_POST['Event']['images']) && is_array($_POST['Event']['images']))
			{
				foreach($_POST['Event']['images'] as $index => $image)
				{
					$Image = EventImage::model()->findByPk($image);
					if($Image !== null)
					{
						$Image->delete();
					}
				}
			}
			
			if($model->validate())
			{
				$model->save();
				
				//Save images
				$images = CUploadedFile::getInstancesByName('images');
				if(isset($images) && sizeof($images))
				{
					foreach($images as $single_image)
					{	
						$Image = new EventImage;
						$Image->event_id = $model->id;
						$Image->uploaded_image = $single_image;
						$Image->save();
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
		$dataProvider=new CActiveDataProvider(Event::model()->other());
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionOptions($id)
	{
		$EventSession = new EventSession;
		$Event = $this->loadModel($id);
		$dataProvider=new CActiveDataProvider('EventInstance', array(
			'criteria'=>array(
				'condition'=>'event_id=' . $id,
			))
		);
		
		if(isset($_POST['EventSession']))
		{
			$EventSession->attributes = $_POST['EventSession'];
			
			if(isset($_POST['event-date']))
			{
				$EventSession->date = $_POST['event-date'];
			}
			
			if($EventSession->validate(array('date', 's_time', 'e_time')))
			{
				$EventInstance = new EventInstance;
				$EventInstance->event_id = $id;
				$EventInstance->save();
				
				$EventSession->instance_id = $EventInstance->id;
				$EventSession->save();
				$this->redirect(array('options','id' => $id));
			}
		}
		
		$this->render('options',array(
			'dataProvider'=>$dataProvider,
			'Event'=>$Event,
			'EventSession'=>$EventSession,
		));		
	}
	
	public function actionQuotes($id)
	{
		$Event = $this->loadModel($id);
		$EventQuote = new EventQuote;
		$EventQuote->event_id = $id;
		
		$dataProvider =  new CArrayDataProvider('EventQuote');
        $dataProvider->setData($Event->quotes);
        
        if(isset($_POST['EventQuote']))
		{
			$EventQuote->attributes = $_POST['EventQuote'];
			
			if($EventQuote->validate())
			{
				$EventQuote->save();
				$this->redirect(array('quotes','id' => $id));
			}
		}
				
		$this->render('quotes',array(
			'dataProvider'=>$dataProvider,
			'Event'=>$Event,
			'EventQuote'=>$EventQuote,
		));
	}

	public function loadModel($id)
	{
		$model=Event::model()->findByPk($id);
		if($model===null || $model->type != Event::TYPE_OTHER)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='event-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
