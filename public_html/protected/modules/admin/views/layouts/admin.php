<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/_css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/_css/jquery.fancybox.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/_css/jquery.Jcrop.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/_css/admin.css" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/_css/ie.css" media="screen, projection" />
	<![endif]-->
	
	<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
	<?php Yii::app()->clientScript->registerScriptFile('/_js/bootstrap.min.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile('/_js/jquery.fancybox.pack.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile('/_js/jquery.Jcrop.min.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile('/_js/admin.js'); ?>
	
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<?php echo CHtml::link("CLPE Admin", array("//admin"), array('class'=>'brand')); ?>
				<ul class="nav">
					<!--<li><?php echo CHtml::link("Slides", array("slide/index")); ?></li>-->
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Events<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><?php echo CHtml::link("Courses", array("course/index")); ?></li>
							<li><?php echo CHtml::link("Conferences", array("conference/index")); ?></li>
							<li><?php echo CHtml::link("Other Events", array("event/index")); ?></li>
							<li class="divider"></li>
							<li><?php echo CHtml::link("Categories", array("category/index")); ?></li>
							<li><?php echo CHtml::link("Targets", array("target/index")); ?></li>
						</ul>
					</li>
					<li><?php echo CHtml::link("Ann's BOTW", array("book/index")); ?></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Publications<b class="caret"></b></a>
						<ul class="dropdown-menu">
        					<li><?php echo CHtml::link("Publications", array("publication/index")); ?></li>
        					<li><?php echo CHtml::link("Bookpacks", array("bookpack/index")); ?></li>
						</ul>
					</li>
					<li><?php echo CHtml::link("News", array("news/index")); ?></li>
					<li class="divider-vertical"></li>
					<li><?php echo CHtml::link("Pages", array("page/index")); ?></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Sections<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php 
								$Navs = Nav::model()->findAll();
								foreach($Navs as $Nav)
								{
									$Page = Page::model()->findByPk($Nav->page_id);
									echo '<li>' . CHtml::link($Page->title, array("nav/update", 'id' =>$Nav->id)) . '</li>';
								}
							?>
						</ul>
					</li>
					<li class="divider-vertical"></li>
					<li><?php echo CHtml::link("Users", array("user/index")); ?></li>
					<li class="divider-vertical"></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Orders<b class="caret"></b></a>
						<ul class="dropdown-menu">
                            <li><?php echo CHtml::link("View All Orders", array("order/index")); ?></li>
							<li class="divider"></li>
                            <li><?php echo CHtml::link("Postage Weight Ranges", array("postageweight/index")); ?></li>
                            <li><?php echo CHtml::link("Book Pack Postage", array("postagebookpack/index")); ?></li>
						</ul>
					</li>
				</ul>
				<ul class="nav pull-right">
					<li><?php echo CHtml::link("View Site", array("/site/index")); ?></li>
					<li>
					<?php 
						if(!Yii::app()->user->isGuest)
						{ 
							echo CHtml::link("Logout", array("/site/logout"));
						}
						else
						{
							echo CHtml::link("Login", array("/site/login"));
						}
						?>
					</li>
				</ul>
			</div>
		</div>
	</div>
<div class="container page_container">
	<?php echo $content; ?>
</div>

</body>
</html>