<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/_css/normalise.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/_css/jquery.fancybox.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/_css/main.css" />
	<script type="text/javascript">
	    var server_ip_address = '<?php echo $_SERVER['SERVER_ADDR']; ?>';
	</script>
	<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
	<?php Yii::app()->clientScript->registerScriptFile('/_js/jquery.fancybox.pack.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile('/_js/jquery.isotope.min.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile('/_js/webfonts.js'); ?>
	
	<script type="text/javascript" src="//use.typekit.net/cyo7vgl.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>

	<title><?php echo strlen($this->pageTitle) ? $this->pageTitle : 'Quizmas!'; ?></title>
</head>

<body>
	<?php echo $content; ?>
</body>
</html>