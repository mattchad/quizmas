<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

	<?php
    	//Normalise CSS
    	//Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/_css/normalise.css');

    	//Bootstrap CSS
    	Yii::app()->clientScript->registerCssFile('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css');
    	
    	//Fancybox CSS
    	Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/_css/jquery.fancybox.css');
    	
    	//Main CSS
    	Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/_css/main.css');
    	
        //Define the server address, so the JS knows where to find the websocket server
    	Yii::app()->clientScript->registerScript('server_ip_address',"var server_ip_address = '" . $_SERVER['SERVER_ADDR'] . "'", CClientScript::POS_HEAD);
    	
    	// jQuery
    	Yii::app()->clientScript->registerCoreScript('jquery', CClientScript::POS_END);
    	
    	// Bootstrap
        Yii::app()->clientScript->registerScriptFile('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js', CClientScript::POS_END);
        
        // Fancybox
        Yii::app()->clientScript->registerScriptFile('/_js/jquery.fancybox.pack.js', CClientScript::POS_END);
        
        // Isotope
        Yii::app()->clientScript->registerScriptFile('/_js/jquery.isotope.min.js', CClientScript::POS_END);
        
        // Typekit / Fonts
        Yii::app()->clientScript->registerScriptFile('/_js/webfonts.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile('//use.typekit.net/cyo7vgl.js', CClientScript::POS_END); 
        Yii::app()->clientScript->registerScript('typekit',"try{Typekit.load();}catch(e){}");
	?>
	
	<title><?php echo strlen($this->pageTitle) ? $this->pageTitle : 'Quizmas!'; ?></title>
</head>

<body>
	<?php echo $content; ?>
</body>
</html>