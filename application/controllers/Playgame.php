<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Playgame extends CI_Controller {

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
			$this->load->view('playgame');
		}
	}
	
	public function startGame()
	{
		$gameNo = $this->Commonmodel->getGameNo();
		if(count($gameNo->result()) == 0){
			$game_no = 1;
		}else{
			foreach($gameNo->result() as $gameNoResult){
				$game_no = $gameNoResult->game_no + 1;
			}
		}
		$data = array(
			"user_id"=>$this->session->userdata('userid'),
			"game_no"=>$game_no
		);
		$this->Commonmodel->insertGameNo($data);
	}
	
	public function addComment()
	{
		$html = "";
		$comment = $_POST['attacker']." ".$_POST['randomAction']." ".$_POST['defender']." by ".abs($_POST['randomHealth']);
		$gameNo = $this->Commonmodel->getGameNo();
		foreach($gameNo->result() as $gameNoResult){
			$game_no = $gameNoResult->game_no;
		}
		
		$data = array(
			"user_id"=>$this->session->userdata('userid'),
			"comment"=>$comment,
			"game_no"=>$game_no
		);
		if($this->Commonmodel->insertComment($data)){
			$getComments = $this->Commonmodel->getComments($game_no);
			foreach($getComments->result() as $getCommentsResult){
				$html .= '<p class="m-0">'.$getCommentsResult->comment.'</p>';
			}
			$response = array("result"=>"success","html"=>$html);
			echo json_encode($response);
		}
	}
	
	public function updateScore()
	{
		$gameNo = $this->Commonmodel->getGameNo();
		foreach($gameNo->result() as $gameNoResult){
			$game_no = $gameNoResult->game_no;
		}
		$data = array(
			"player_score"=>$_POST['playerFinalHealth'],
			"dragon_score"=>$_POST['dragonFinalHealth']
		);
		$this->Commonmodel->updateScore($data,$game_no);
	}
	
	public function listGames()
	{
		$data['getAllGames'] = $this->Commonmodel->getAllGames();
		$this->load->view('include');
		$this->load->view('header');
		$this->load->view('listgames',$data);
	}
}
