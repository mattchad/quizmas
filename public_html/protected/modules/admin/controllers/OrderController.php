<?php

class OrderController extends AdController
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
				'actions'=>array('index','paid','unpaid','update'),
				'roles'=>array('admin', 'editor'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionUpdate($id)
	{
		$Order = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Order']))
		{
			$Order->attributes=$_POST['Order'];
						
			if($Order->validate())
			{
				$Order->save();
				$this->redirect(array('update','id'=>$Order->id));
			}
		}
		
		$this->render('update',array(
			'Order'=>$Order,
		));
	}

	/* public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(array('index'));
	} */

	public function actionIndex()
	{
	    $OrderFilter = new Order('search');
	    $OrderFilter->unsetAttributes();
	    
	    if(isset($_GET['Order']))
	    {
    	    $OrderFilter->attributes=$_GET['Order'];
	    }

		$dataProvider=new CActiveDataProvider('Order',array('pagination'=>false, 'criteria'=>$OrderFilter->searchCriteria()));
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'OrderFilter'=>$OrderFilter,
		));
	}

	public function loadModel($id)
	{
		$model=Order::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested order does not exist.');
		return $model;
	}
}
