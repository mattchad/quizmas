<?php

class EventsessionController extends AdController
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
				'actions'=>array('delete'),
				'roles'=>array('admin', 'editor'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionDelete($id)
	{
		$EventSession = $this->loadModel($id);
		$EventInstance = EventInstance::model()->findByPk($EventSession->instance_id);
		if(sizeof($EventInstance->sessions) > 1)
		{
			$EventSession->delete();
		}
		$this->redirect(array('eventinstance/update', 'id'=>$EventInstance->id));
	}

	public function loadModel($id)
	{
		$model=EventSession::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='EventSession-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
