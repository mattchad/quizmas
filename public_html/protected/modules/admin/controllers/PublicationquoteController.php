<?php

class PublicationquoteController extends AdController
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
		$PublicationQuote = $this->loadModel($id);
		$Publication = $PublicationQuote->publication;
		$PublicationQuote->delete();
		
		$this->redirect(array('publication/quotes', 'id'=>$Publication->id));
	}

	public function loadModel($id)
	{
		$PublicationQuote = PublicationQuote::model()->findByPk($id);
		if($PublicationQuote === null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $PublicationQuote;
	}
}
