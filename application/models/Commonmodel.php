<?php
class Commonmodel extends CI_Model {

	public function checkLogin($username,$password)
	{
		$this->db->select('id');
		$this->db->from('users');
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		return $this->db->get();
	}
	
	public function insertComment($data)
	{
		if($this->db->insert('commentary', $data)){
			return true;
		}else{
			return false;
		}
	}
	
	public function insertGameNo($data)
	{
		if($this->db->insert('game_history', $data)){
			return true;
		}else{
			return false;
		}
	}
	
	public function getComments($game_no)
	{
		$this->db->select('comment');
		$this->db->from('commentary');
		$this->db->where('user_id', $this->session->userdata('userid'));
		$this->db->where('game_no', $game_no);
		$this->db->order_by("id", "desc");
		$this->db->limit(10);
		return $this->db->get();
	}
	
	public function getGameNo()
	{
		$this->db->select('*');
		$this->db->from('game_history');
		$this->db->where('user_id', $this->session->userdata('userid'));
		$this->db->order_by("id", "desc");
		$this->db->limit(1);
		return $this->db->get();
	}
	
	public function updateScore($data,$gameNo)
	{
		$this->db->where('user_id', $this->session->userdata('userid'));
		$this->db->where('game_no', $gameNo);
		if($this->db->update('game_history', $data)){
			return true;
		}else{
			return false;
		}
	}
	
	public function getAllGames()
	{
		$this->db->select('*');
		$this->db->from('game_history');
		$this->db->where('user_id', $this->session->userdata('userid'));
		$this->db->order_by("id", "desc");
		return $this->db->get();
	}
	
	public function insertUser($data)
	{
		if($this->db->insert('users', $data)){
			return true;
		}else{
			return false;
		}
	}
}
?>