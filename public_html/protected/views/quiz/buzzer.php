<?php 
    Yii::app()->clientScript->registerMetaTag('yes', 'apple-mobile-web-app-capable');
    Yii::app()->clientScript->registerMetaTag('yes', 'mobile-web-app-capable');
    Yii::app()->clientScript->registerLinkTag('apple-touch-icon', '', '/_images/iphone-buzzer.png');
?>

<ul id="choose_player" class="screen nav_list"></ul>

<div id="buzzer" class="screen buzzer">Buzz</div>

<div id="quizmaster" class="screen">
	<div class="password">
	    <div class="inner">
    	    <span><input type="password" value="" id="password" placeholder="Enter Password" /></span>
    	    <span><input type="button" class="button" value="Unlock Round" id="unlock_round" /></span>
	    </div>
    </div>
	<div class="next" id="next">Next</div>
	<div class="correct" id="correct">Correct</div>
	<div class="incorrect" id="incorrect">Incorrect</div>
	<div class="waiting" id="waiting">Waiting</div>
</div>