<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		if(!$this->session->userdata('userid'))
		{
			$this->load->view('include');
			$this->load->view('login');
		}
		else
		{
			redirect(base_url().'main');
		}
	}
	
	public function checkLogin()
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		$userCheck = $this->Commonmodel->checkLogin($username,$password);
		if(count($userCheck->result()) == 1)
		{
			foreach($userCheck->result() as $userCheckResult){
				$userId = $userCheckResult->id;
			}
			$this->session->set_userdata('userid', $userId);
			$this->session->set_userdata('username', $username);
			$response = array("result"=>"success");
		}
		else
		{
			$response = array("result"=>"error","message"=>"Please check entered credentials");
		}
		echo json_encode($response);
	}
	
	public function logoutUser()
	{
		$this->session->unset_userdata('userid');
		$this->session->unset_userdata('username');
		redirect(base_url().'login');
	}
	
	public function register()
	{
		if(!$this->session->userdata('userid'))
		{
			$this->load->view('include');
			$this->load->view('register');
		}
		else
		{
			redirect(base_url().'main');
		}
	}
	
	public function checkRegister()
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		$userCheck = $this->Commonmodel->checkLogin($username,$password);
		if(count($userCheck->result()) == 1)
		{
			$response = array("result"=>"exists","message"=>"The username and password combination already exists!");
		}
		else
		{
			$data = array(
				"username"=>$username,
				"password"=>$password
			);
			if($this->Commonmodel->insertUser($data)){
				$response = array("result"=>"success","message"=>"You are registered, please login");
			}
		}
		echo json_encode($response);
	}
}
