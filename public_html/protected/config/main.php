<?php
$db = array(
	'connectionString' => 'mysql:host=localhost;dbname=quizmas',
	'emulatePrepare' => true,
	'username' => 'root',
	'password' => '',
	'charset' => 'utf8',
);

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
require_once( dirname(__FILE__) . '/../components/helpers.php');
//require_once( dirname(__FILE__) . '/../components/Netcarver/Textile/Parser.php');
//require_once( dirname(__FILE__) . '/../components/Netcarver/Textile/Databag.php');
//require_once( dirname(__FILE__) . '/../components/Netcarver/Textile/Tag.php');

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Quizmas!',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.lib.*',
	),

	'modules'=>array(
		'admin',
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'password',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'class'=>'WebUser',
		),

		'functions'=>array(
			'class'=>'application.extensions.Functions'
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

				/* '<category:\w+>/<slug:[a-z\-]+>-<id:\d+>' => 'blog/view', */
				/* '<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',*/
			),
		),
		
		/* 'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		
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