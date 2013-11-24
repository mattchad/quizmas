<div id="scoreboard">
<?php 
	foreach($Players as $Player)
	{
?>
		<div class="player" id="player_<?php echo $Player->id; ?>">
			<h2 class="name"><?php echo $Player->last_name; ?></h2>
			<p class="score"><?php echo $Player->score;?></p>
			<p class="connected">No</p>
		</div>
<?php 		
	}
?>
</div>
<audio id="ping" preload="auto">
	<source src="/_sounds/ping.ogg" type="audio/ogg" />
</audio>