<meta name="apple-mobile-web-app-capable" content="yes">
<link rel="apple-touch-icon" href="/_images/iphone-quizmaster.png"/>  

<ul id="quizmaster" class="nav_list">
	<li class="spacer_bottom"><a href="#" id="unlock_buzzers">Buzzers Active</a></li>
<?php 
	foreach($Players as $Player)
	{
?>
		<li class="player" id="player_<?php echo $Player->id; ?>" data-id="<?php echo $Player->id; ?>"><a href="#" class="add">+</a><span><?php echo $Player->last_name; ?></span><a href="#" class="subtract">-</a></li>
<?php 		
	}
?>
</div>