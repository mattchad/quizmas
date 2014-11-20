<?php $this->beginContent('//layouts/main'); ?>
<?php 
	// Bootstrap
    Yii::app()->clientScript->registerScriptFile('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js');

    //Bootstrap CSS 
    Yii::app()->clientScript->registerCssFile('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css');
    
    //Admin CSS
    Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/_css/admin.css');
    
    //Admin JS
    Yii::app()->clientScript->registerScriptFile('/_js/admin.js');
?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
          <!-- <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button> -->
          <a class="navbar-brand" href="/"><?php echo Yii::app()->name; ?></a>
        </div>
        <!-- <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
        </div><!--/.nav-collapse -->
        <div id="navbar" class="collapse navbar-collapse pull-right">
            <ul class="nav navbar-nav">
                <li><?php echo CHtml::link('Logout', array('site/logout')); ?></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <?php
        foreach(Yii::app()->user->getFlashes() as $key => $message)
        {
            ?>
            <div class="alert alert-<?php echo $key; ?>" role="alert"><?php echo $message; ?></div>
            <?php
        }
    ?>
    <?php echo $content; ?>
</div>

<?php $this->endContent(); ?>