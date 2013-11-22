<?php

class EventinstanceController extends AdController
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
	
	protected function beforeAction($action)
	{
	    //Prevents logging being displayed on CSV
	    if($action->id == 'attendees')
	    {
            foreach (Yii::app()->log->routes as $route)
            {
                if ($route instanceof CWebLogRoute)
                {
                    $route->enabled = false;
                }
            }
        }
        return true;
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
				'actions'=>array('update', 'delete', 'attendees'),
				'roles'=>array('admin', 'editor'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionAttendees($id)
	{
    	$EventInstance=$this->loadModel($id);
    	
    	header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename=option' . $id . '_attendees_' . date('Y-m-d-H-i-s') . '.csv');
        header('Pragma: no-cache');
    	
    	foreach($EventInstance->attendees as $Attendee)
    	{
    	    $attendee = array();
    	    array_push($attendee, $Attendee->first_name, $Attendee->last_name, $Attendee->email_address, $Attendee->order->billingAddress->company, $Attendee->order->billingAddress->address_1, $Attendee->order->billingAddress->address_2, $Attendee->order->billingAddress->city, $Attendee->order->billingAddress->post_code, $Attendee->order->billingAddress->country);
        	echo str_putcsv($attendee) . "\n";
    	}
    	Yii::app()->end();
	}

	public function actionUpdate($id)
	{
		$EventInstance=$this->loadModel($id);
		
		$EventSession = new EventSession;
		$EventSession->instance_id = $id;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['EventSession']))
		{
			$EventSession->attributes = $_POST['EventSession'];
			
			if(isset($_POST['event-date']))
			{
				$EventSession->date = $_POST['event-date'];
			}
			
			if($EventSession->validate(array('date', 's_time', 'e_time')))
			{
				$EventSession->save();
				$this->redirect(array('update','id' => $id));
			}
		}
		
		$attendeeProvider = new CArrayDataProvider('Attendee');
        $attendeeProvider->setData($EventInstance->attendees);
		
		$this->render('update',array(
			'EventInstance'=>$EventInstance,
			'EventSession'=>$EventSession,
			'attendeeProvider'=>$attendeeProvider,
		));
	}
	
	public function actionDelete($id)
	{
	    $EventInstance = $this->loadModel($id);
	    $Event = $EventInstance->event;
	    $EventInstance->delete();
    	$this->redirect($Event->optionsRoute);
	}

	public function loadModel($id)
	{
		$model=EventInstance::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='EventInstance-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
