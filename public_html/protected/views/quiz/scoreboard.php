<div id="scoreboard">
<?php 
	foreach($Players as $Player)
	{
?>
		<div class="player" id="player_<?php echo $Player->id; ?>">
			<p class="photo"><img src="/_images/<?php echo $Player->photo_file; ?>" /></p>
			<div class="board">
				<p class="time"></p>
			    <div class="board_inner board_top">
			    	<div class="name_outer">
    					<p class="name"><?php echo $Player->last_name; ?></p>
			    	</div>
			    </div>
			    <div class="board_middle">
			    	<span></span>
			    </div>
			    <div class="board_inner board_bottom">
			    	<div class="score_outer">
    					<p class="score"><?php echo $Player->points;?></p>
    				</div>
			    </div>
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
<audio id="correct" preload="auto">
	<source src="/_sounds/correct.ogg" type="audio/ogg" />
</audio>
<audio id="incorrect" preload="auto">
	<source src="/_sounds/incorrect.ogg" type="audio/ogg" />
</audio>