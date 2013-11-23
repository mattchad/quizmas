<?php
$db = array(
	'connectionString' => 'mysql:host=localhost;dbname=quizmas',
	'emulatePrepare' => true,
	'username' => 'root',
	'password' => '',
	'charset' => 'utf8',
);


return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.lib.*',
	),
	// application components
	'components'=>array(

		'db'=>$db,
	),

    'commandMap'=>array(
        'migrate'=>array(
            'class'=>'system.cli.commands.MigrateCommand',
            'migrationPath'=>'application.migrations',
            'migrationTable'=>'yii_migration',
            'connectionID'=>'db',
            //'templateFile'=>'application.migrations.template',
        ),
    ),

);