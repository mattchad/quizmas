<?php

class EventquoteController extends AdController
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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
		$EventQuote = $this->loadModel($id);
		$Event = $EventQuote->event;
		$EventQuote->delete();
		switch($Event->type)
		{
    		case Event::TYPE_COURSE:
    		{
    		    $this->redirect(array('course/quotes', 'id'=>$Event->id));
        		break;
    		}
    		case Event::TYPE_CONFERENCE:
    		{
    		    $this->redirect(array('conference/quotes', 'id'=>$Event->id));
        		break;
    		}
    		case Event::TYPE_OTHER:
    		{
    		    $this->redirect(array('event/quotes', 'id'=>$Event->id));
        		break;
    		}
		}
	}

	public function loadModel($id)
	{
		$EventQuote = EventQuote::model()->findByPk($id);
		if($EventQuote === null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $EventQuote;
	}
}
