<div class="container-fluid row">
	<div class="col-sm-8 mt-2 text-center">
		<div><div class="countdown">Countdown</div><div id="timer"></div></div>
	</div>
	<div class="col-sm-4 mt-2 text-center">
		<p class="text-center">Commentary Box</p>
	</div>
	<div class="col-sm-4 text-center mt-5">
		<img class="img-fluid playerimg" alt="Responsive image" src="<?php echo base_url();?>assets/img/fighter.gif"/>
		<div class="progress mt-3">
		  <div class="progress-bar" id="playerhealth" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
		</div>
	</div>
	<div class="col-sm-4 text-center mt-5">
		<img class="img-fluid dragonimg" alt="Responsive image" src="<?php echo base_url();?>assets/img/dragon.gif"/>
		<div class="progress mt-3">
		  <div class="progress-bar" id="dragonhealth" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
		</div>
	</div>
	<div class="col-sm-4 p-2 commentarybox">
	</div>
	<div class="col-sm-8 mt-3 text-center actionbuttons d-none">
		<input type="button" class="btn btn-info btn-sm attack" value="Attack">
		<input type="button" class="btn btn-info btn-sm powerattack" value="Power Attack">
		<input type="button" class="btn btn-info btn-sm heal" value="Heal">
		<input type="button" class="btn btn-info btn-sm surrender" value="Surrender">
	</div>
	<div class="col-sm-8 mt-5 text-center playagain d-none">
		<input type="button" class="btn btn-info btn-sm p-3 matchresult" value="">
		<a class="p-3 actionButton btn" href="<?php echo base_url();?>playgame">Play Again</a>
		<a class="p-3 actionButton btn" href="<?php echo base_url();?>playgame/listGames">View Games</a>
	</div>
	<div class="col-sm-8 mt-5 text-center">
		<a class="p-3 actionButton btn" id="startgame" href="javascript:void(0)">Start Game</a>
	</div>
	<input type="hidden" class="username" value="<?php echo $this->session->userdata('username');?>"/>
</div>

<script src="<?php echo base_url();?>assets/js/common.js"></script>