<div id="scoreboard">
<?php 
	foreach($Players as $Player)
	{
?>
		<div class="player" id="player_<?php echo $Player->id; ?>">
			<p class="connected">No</p>
			<p class="photo"><img src="/_images/dbp.jpg" /></p>
			<div class="board">
				<p class="score"><?php echo $Player->points;?></p>
				<p class="name"><?php echo $Player->last_name; ?><span class="time"></span></p>
			</div>
			<audio id="player_<?php echo $Player->id; ?>_sound" preload="auto">
				<source src="/_sounds/player_<?php echo $Player->id; ?>.ogg" type="audio/ogg" />
			</audio>
		</div>
<?php 		
	}
?>
</div>
<audio id="add" preload="auto">
	<source src="/_sounds/add.ogg" type="audio/ogg" />
</audio>
<audio id="subtract" preload="auto">
	<source src="/_sounds/subtract.ogg" type="audio/ogg" />
</audio>