<?php
class Agent_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function profile($id)
	{
		$user = $this->db->get_where('register_agent',['id' => $id])->row_object();
		$userDet = $this->db->get_where('details_agent',['user' => $user->id])->row_object();
		if ($this->general_model->getFile($userDet->fileprofile,'uploads/agent/') != "") {
			return $this->general_model->getFile($userDet->fileprofile,'uploads/agent/');
		}else{
			return base_url('uploads/placeholders/placeholder512.png');
		}
	}

	public function iddoc($id)
	{
		$user = $this->db->get_where('register_agent',['id' => $id])->row_object();
		$userDet = $this->db->get_where('details_agent',['user' => $user->id])->row_object();
		if ($this->general_model->getFile($userDet->fileid,'uploads/agent/') != "") {
			return $this->general_model->getFile($userDet->fileid,'uploads/agent/');
		}else{
			return base_url('uploads/placeholders/placeholder512.png');
		}
	}

	public function fileaddt($id)
	{
		$user = $this->db->get_where('register_agent',['id' => $id])->row_object();
		$userDet = $this->db->get_where('details_agent',['user' => $user->id])->row_object();
		if ($this->general_model->getFile($userDet->fileaddress,'uploads/agent/') != "") {
			return $this->general_model->getFile($userDet->fileaddress,'uploads/agent/');
		}else{
			return base_url('uploads/placeholders/placeholder512.png');
		}
	}

	public function get($user)
	{
		$user = $this->db->get_where('register_agent',['id' => $user])->row_object();
		$userDet = $this->db->get_where('details_agent',['user' => $user->id])->row_object();
		$user->name = ucfirst($user->name);
		$userDet->fileprofile 	= $this->profile($user->id);
		$userDet->fileid 		= $this->iddoc($user->id);
		$userDet->fileaddress	= $this->fileaddt($user->id);
		$user->detail			= $userDet;
		return $user;
	}
}