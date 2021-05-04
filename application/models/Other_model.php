<?php
class Other_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	public function saveNotification($main,$main_type,$user,$user_type,$title,$desc){
		$this->db->insert('notifications',[
			'user'				=> $user,
			'user_type'			=> $user_type,
			'main'				=> $main,
			'main_type'			=> $main_type,
			'title'				=> $title,
			'descr'				=> $desc,
			'cat'				=> _nowDateTime()
		]);
	}

}