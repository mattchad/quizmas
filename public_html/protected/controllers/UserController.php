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
			array('deny',
				'users'=>array('*'),
			),
		);
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