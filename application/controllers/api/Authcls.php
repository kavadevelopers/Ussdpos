<?php
class Authcls extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}


	public function api_register()
	{
		if ($this->input->post('name') && $this->input->post('business') && $this->input->post('email') && $this->input->post('country') && $this->input->post('password')) {
			$data = [
				'name'		=> $this->input->post('name'),
				'business'	=> $this->input->post('business'),
				'email'		=> $this->input->post('email'),
				'country'	=> $this->input->post('country'),
				'password'	=> md5($this->input->post('password')),
				'block'		=> "",
				'df'		=> "",
				'cat'		=> _nowDateTime()
			];
			$this->db->insert('provider',$data);
			retJson(['_return' => true,'msg' => 'Registration Success.']);
		}else{
			retJson(['_return' => false,'msg' => '`name`,`business`,`email`,`country`,`password` are Required']);
		}
	}
}