<div id="scoreboard">
<?php 
	foreach($Players as $Player)
	{
?>
		<div class="player" id="player_<?php echo $Player->id; ?>">
			<p class="photo"><img src="/_images/<?php echo $Player->photo_file; ?>" /></p>
			<div class="board">
				<p class="score"><?php echo $Player->points;?></p>
				<p class="name"><?php echo $Player->last_name; ?><span class="time"></span></p>
			</div>
			<audio id="player_<?php echo $Player->id; ?>_sound" preload="auto">
				<source src="/_sounds/<?php echo $Player->sound_file; ?>" type="audio/ogg" />
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