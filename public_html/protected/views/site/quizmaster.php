<meta name="viewport" content="width=device-width, initial-scale=1.0">
<ul id="quizmaster" class="nav">
	<li class="spacer_bottom"><a href="#" id="unlock_buzzers">Unlock Buzzers</a></li>
<?php 
	foreach($Players as $Player)
	{
?>
		<li class="player" id="player_<?php echo $Player->id; ?>"><a href="#" class="up">+</a><span><?php echo $Player->last_name; ?></span><a href="#" class="down">-</a></li>
<?php 		
	}
?>
</div>