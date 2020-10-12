<div class="container mt-3">
	<a class="p-3 actionButton btn mb-2" href="<?php echo base_url();?>playgame">Play Game</a>
	<table id="listgames" class="table" width="100%">
	  <thead>
		<tr>
		  <th class="th-sm">Game no
		  </th>
		  <th class="th-sm">Your score
		  </th>
		  <th class="th-sm">Dragon Score
		  </th>
		</tr>
	  </thead>
	  <tbody>
		<?php foreach($getAllGames->result() as $getAllGamesResult){?>
			<tr>
				<td><?php echo $getAllGamesResult->game_no;?></td>
				<td><?php echo $getAllGamesResult->player_score;?></td>
				<td><?php echo $getAllGamesResult->dragon_score;?></td>
			</tr>
		<?php }?>
	  </tbody>
	</table>
</div>

<script src="<?php echo base_url();?>assets/js/common.js"></script>