<?php
class Login_model extends CI_Model
{
	public function login_Ath($user,$pass)
	{
		$user = $this->db->escape($user);
		$select = $this->db->query("SELECT * FROM `user` WHERE username = $user AND `df` = ''" );

		if($select->num_rows() > 0)
		{
			$data = $select->result_object();
			if($data[0]->password === $pass)
			{
				return array(0,'Login Successfull...',$data[0]->id,$data[0]->user_type);
			}
			else
			{
				return array(1,'Username And Password Not Match','');
			}
		}
		else
		{
			return array(1,'Username Not Registered','');
		}
	}


	public function firebaseLogin($user)
	{
		$data = [
			'descr'		=> $this->input->post('descr'),
			'token'		=> $this->input->post('token'),
			'device'	=> $this->input->post('device'),
			'device_id'	=> $this->input->post('device_id'),
			'user'		=> $user,
			'cat'		=> _nowDateTime()
		];
		$this->db->insert('firebase_agent',$data);
	}
}

?>