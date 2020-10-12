<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function index()
	{
		if (!$this->session->userdata('userid'))
		{
			redirect(base_url().'login');
		}
		else
		{
			$this->load->view('include');
			$this->load->view('header');
			$this->load->view('main');
		}
	}
}
