<div class="container-fluid p-0 headerMain">
	<div class="col-sm-12 headerChild">
		<label class="m-0 welcomeText">Welcome, <?php echo $this->session->userdata('username');?></label>
		<button type="button" class="btn btn-info btn-sm logout">Logout</button>
		<input type="hidden" class="baseurl" value="<?php echo base_url();?>"/>
	</div>
</div>