<?php

class UserController extends Controller
{
	public function filters()
	{
		return array(
			'accessControl',
		);
	}

	public function accessRules()
	{
		return array(
			array('allow', 
				'actions'=>array('reset'),
				'users'=>array('*'),
			),
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index', 'question', 'delete', 'order'),
				'users'=>array('@'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}
	
	public function actionIndex()
	{
    	Yii::app()->clientScript->registerCoreScript('jquery.ui', CClientScript::POS_END);
    	$this->render('index', array('User'=>Yii::app()->user));
	}
	
	public function actionOrder()
	{
    	foreach($_POST['orderData'] as $key => $question_id)
    	{
        	$Question = Question::model()->findByAttributes(array('id'=>$question_id, 'user_id'=>Yii::app()->user->id));
        	
        	if(!is_null($Question))
        	{
            	$Question->list_order = (int)$key;
            	$Question->save(false);
        	}
    	}
	}
	
	public function actionQuestion($id = null)
	{
    	if(is_null($id))
    	{
        	$Question = new Question;
        	$Question->user_id = Yii::app()->user->id;
    	}
    	else
    	{
            //$Question = Question::model()->findByAttributes(array('id'=>$id, 'user_id'=>Yii::app()->user->id));
            $Question = null;
    	}
    	
    	if(is_null($Question))
    	{
        	throw new CHttpException(404,'The requested page does not exist.');
    	}
    	
    	if(isset($_POST['Question']))
    	{
        	$Question->attributes = $_POST['Question'];
        	        	
        	if($Question->validate(array('text', 'value', 'user_id', 'password')))
        	{            	
            	//Let the user know. 
            	Yii::app()->user->setFlash('success' ,'That question has been ' . ($Question->isNewRecord ? 'created' : 'updated'));
            	
            	//Save the question
                $Question->save(false);
            	
            	//Go back to the question list
            	$this->redirect(array('user/index'));
        	}
    	}
    	
    	$this->render('question', array('Question'=>$Question));
	}
	
	public function actionDelete($id)
	{
    	$Question = Question::model()->findByAttributes(array('id'=>$id, 'user_id'=>Yii::app()->user->id));
    	
    	if(is_null($Question))
    	{
        	throw new CHttpException(404,'The requested page does not exist.');
    	}
    	
    	//Delete the question
    	$Question->delete();
    	
    	//Set a message to the user confirming the question was deleted
    	Yii::app()->user->setFlash('success' ,'That question has been deleted.');
		
		//Redirect the user back to the home page. 
		$this->redirect(array('user/index'));
    	
	}
	
	public function actionReset($hash)
	{
    	//Try and find a user with this hash.
    	$User = User::model()->findByAttributes(array('hash'=>$hash));
    	
    	if(is_null($User))
    	{
        	//We couldn't find a user with this hash. Throw an error. 
        	throw new CHttpException(404,'The requested page does not exist.');
    	}
    	
    	if(isset($_POST['User']))
    	{
        	$User->attributes = $_POST['User'];
        	
        	if($User->validate(array('password')))
        	{
            	//Hash this password before saving
                $User->password = Hash::create_hash($User->password);

            	//Set the hash to null so that they can't revisit using this hash. 
                $User->hash = '';
                
                //Save the password and hash fields. 
            	$User->save(false, array('password', 'hash'));
            	
            	//Set a message to the user confirming their password has changed.
            	Yii::app()->user->setFlash('success' ,'Your password has been changed. You can now log in.');
				
				//Redirect the user back to the login page. 
				$this->redirect(array('site/login'));
        	}
    	}
    	
    	//These fields should always be empty. Even if something has been entered previously. 
    	$User->password = "";
    	$User->password_repeat = "";
    	
		$this->render('reset', array('User'=>$User));
	}
}