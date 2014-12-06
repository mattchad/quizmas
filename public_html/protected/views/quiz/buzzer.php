<?php 
    Yii::app()->clientScript->registerMetaTag('yes', 'apple-mobile-web-app-capable');
    Yii::app()->clientScript->registerMetaTag('yes', 'mobile-web-app-capable');
    Yii::app()->clientScript->registerLinkTag('apple-touch-icon', '', '/_images/iphone-buzzer.png');
?>

<ul id="choose_player" class="screen nav_list"></ul>

<div id="buzzer" class="screen">
	<a href="#">PRESS ME</a>
</div>

<ul id="quizmaster" class="screen">
	<li class="password">
	    <div class="inner">
    	    <span><input type="text" value="" id="password" placeholder="Enter Password" /></span>
    	    <span><input type="button" class="button" value="Unlock Round" id="unlock_round" /></span>
	    </div>
    </li>
	<li class="next" id="next"><a href="#">Next</a></li>
	<li class="correct" id="correct"><a href="#">Correct</a></li>
	<li class="incorrect" id="incorrect"><a href="#">Incorrect</a></li>
	<li class="waiting" id="waiting">Waiting</li>
</ul>