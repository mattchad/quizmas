<?php
$db = array(
	'connectionString' => 'mysql:host=localhost;dbname=clpe_clpe',
	'emulatePrepare' => true,
	'username' => 'clpe_clpe',
	'password' => 'JmzS3e5lXqW3',
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