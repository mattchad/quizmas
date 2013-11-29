<div id="scoreboard">
<?php 
	foreach($Players as $Player)
	{
?>
		<div class="player" id="player_<?php echo $Player->id; ?>">
			<p class="photo"><img src="/_images/<?php echo $Player->photo_file; ?>" /></p>
			<span class="time"></span>
			<div class="board">
			    <div class="board_inner">
    				<p class="name"><?php echo $Player->last_name; ?></p>
    				<p class="score"><?php echo $Player->points;?></p>
			    </div>
			</div>
			<audio id="player_<?php echo $Player->id; ?>_sound" preload="auto">
				<source src="/_sounds/<?php echo $Player->sound_file; ?>" type="audio/ogg" />
			</audio>
		</div>
<?php 		
	}
?>
    <div class="player"><span class="score" style="display: none;">-99999</span><p>+1</p></div>

</div>
<audio id="add" preload="auto">
	<source src="/_sounds/add.ogg" type="audio/ogg" />
</audio>
<audio id="subtract" preload="auto">
	<source src="/_sounds/subtract.ogg" type="audio/ogg" />
</audio>