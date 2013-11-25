<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<ul id="quizmaster" class="nav">
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