<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

	<?php
        //Define the server address, so the JS knows where to find the websocket server
    	Yii::app()->clientScript->registerScript('server_ip_address',"function getWsServerIP() { return '" . $_SERVER['SERVER_ADDR'] . "'; }", CClientScript::POS_END);
    	
    	// jQuery
    	Yii::app()->clientScript->registerCoreScript('jquery');
    	        
        // Isotope
        Yii::app()->clientScript->registerScriptFile('/_js/jquery.isotope.min.js');
        
        // Typekit / Fonts
        Yii::app()->clientScript->registerScriptFile('/_js/webfonts.js');
        Yii::app()->clientScript->registerScriptFile('//use.typekit.net/cyo7vgl.js'); 
        Yii::app()->clientScript->registerScript('typekit',"try{Typekit.load();}catch(e){}", CClientScript::POS_END);
	?>
	
	<title><?php echo strlen($this->pageTitle) ? $this->pageTitle . ' | Quizmas!' : 'Quizmas!'; ?></title>
</head>

<body>
	<?php echo $content; ?>
</body>
</html>