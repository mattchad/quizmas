<?php
Yii::import('application.modules.admin.controllers.EventController');

class ConferenceController extends EventController
{
	public function actionCreate()
	{
		$model=new Conference;
		$model->venue = 'Centre for Literacy in Primary Education';
		$model->type = Event::TYPE_CONFERENCE;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['Conference']))
		{
			$model->attributes=$_POST['Conference'];
			
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

		if(isset($_POST['Conference']))
		{
			$model->attributes=$_POST['Conference'];
			
			$uploaded_image = CUploadedFile::getInstance($model,'image');
			if($uploaded_image !== null)
			{
				$model->uploaded_image = $uploaded_image;
				$model->image = $uploaded_image;
			}
			
			if(isset($_POST['Conference']['images']) && is_array($_POST['Conference']['images']))
			{
				foreach($_POST['Conference']['images'] as $index => $image)
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
	
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Conference');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function loadModel($id)
	{
		$Conference = Conference::model()->findByPk($id);
		if($Conference === null || $Conference->type != Event::TYPE_CONFERENCE)
			throw new CHttpException(404,'The requested page does not exist.');
		return $Conference;
	}
}

?>
