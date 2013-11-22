<?php
Yii::import('application.modules.admin.controllers.EventController');

class CourseController extends EventController
{
	public function actionCreate()
	{
		$model=new Course;
		$model->venue = 'Centre for Literacy in Primary Education';
		$model->type = Event::TYPE_COURSE;
				
		if(isset($_POST['Course']))
		{
			$model->attributes=$_POST['Course'];
			
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
        
		if(isset($_POST['Course']))
		{
			$model->attributes=$_POST['Course'];
			
			if(isset($_POST['Course']['images']) && is_array($_POST['Course']['images']))
			{
				foreach($_POST['Course']['images'] as $index => $image)
				{
					$Image = EventImage::model()->findByPk($image);
					if($Image !== null)
					{
						$Image->delete();
					}
				}
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
		$dataProvider=new CActiveDataProvider('Course');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function loadModel($id)
	{
		$Course = Course::model()->findByPk($id);
		if($Course === null || $Course->type != Event::TYPE_COURSE)
			throw new CHttpException(404,'The requested page does not exist.');
		return $Course;
	}
}

?>
