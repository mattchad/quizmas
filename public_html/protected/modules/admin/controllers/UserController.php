<?php

class UserController extends AdController
{
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
	    if($action->id == 'export')
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

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(''),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index' ,'update', 'delete', 'export'),
				'roles'=>array('editor'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    public function actionExport()
	{
    	header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename=users_' . date('Y-m-d-H-i-s') . '.csv');
        header('Pragma: no-cache');
    	
    	foreach(User::model()->findAll(array('condition'=>'role=' . User::ROLE_USER)) as $User)
    	{
    	    $user_array = array();
    	    array_push($user_array, $User->first_name, $User->last_name, $User->email_address, $User->position);
        	echo str_putcsv($user_array) . "\n";
    	}
    	Yii::app()->end();
	}
	
	public function actionUpdate($id)
	{
		$User = $this->loadModel($id);
		$User->scenario = 'edit_user';

		if(isset($_POST['User']))
		{
			$User->attributes = $_POST['User'];
			
			if($User->validate())
			{
				$User->save(true, array('first_name', 'last_name', 'email_address', 'role'));
				$this->redirect(array('update','id'=>$User->id));
			}
		}
		
		$this->render('update',array(
			'User'=>$User,
		));
	}

	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		$this->redirect(array('index'));
	}

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('User', array('pagination'=>false));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function loadModel($id)
	{
		$User=User::model()->findByPk($id);
		if($User===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $User;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='publication-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
