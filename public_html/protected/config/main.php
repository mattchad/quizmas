<?php
$db = array(
	'connectionString' => 'mysql:host=localhost;dbname=quizmas',
	'emulatePrepare' => true,
	'username' => 'root',
	'password' => '',
	'charset' => 'utf8',
	'enableProfiling'=>true, 
);

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Quizmas!',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		'admin',
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'class'=>'WebUser',
		),

		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'useStrictParsing'=>true,
			'showScriptName'=>false,
			'rules'=>array(
				''	=> 'site/index',
				'/scoreboard'	=> 'site/scoreboard',
				'/buzzer'	=> 'site/buzzer',
				'/quizmasterz'	=> 'site/quizmaster',
			),
		),
		
		'db'=>$db,
		
		'session'=>array(
            'class' => 'CDbHttpSession',
            'connectionID' => 'db',
            'sessionTableName' => 'yii_session',
        ),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log' => array(
			'class' => 'CLogRouter',
			'routes' => array(
				/* array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				), */
				// This runs the custom logging class that emails errors
				/*array(
					//'class' => 'CustomLogger',
				),
				*/
				// This shows the database profiling at the bottom of the page
				// We're checking for local dev environment
				array(
					'class' => 'CProfileLogRoute',
					'levels' => 'profile',
					'enabled' => ($_SERVER['SERVER_ADDR'] == '127.0.0.1' ? true : false),
				),
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'help@pageplay.com',
	),
);