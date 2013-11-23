<div id="scoreboard">
<?php 
	foreach($Players as $Player)
	{
?>
		<div class="player" id="player_<?php echo $Player->id; ?>">
			<h2 class="name"><?php echo $Player->first_name . ' ' . $Player->last_name; ?></h2>
			<p class="score"><?php echo $Player->score;?></p>
			<p class="connected">No</p>
		</div>
<?php 		
	}
?>
<a href="#" id="unlock">Unlock Buzzers</a>
</div>