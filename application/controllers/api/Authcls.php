<?php
class Authcls extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function login()
	{
		if ($this->input->post('email') && $this->input->post('password')) {
			$user = $this->db->get_where('provider',['email' => $this->input->post('email')])->row_array();
			if ($user) {
				if (md5($this->input->post('password')) == $user['password']) {
					retJson(['_return' => true,'data' => $user]);	
				}else{
					retJson(['_return' => false,'msg' => 'Password not match.']);	
				}
			}else{
				retJson(['_return' => false,'msg' => 'Email not registered']);
			}
		}else{
			retJson(['_return' => false,'msg' => '`email`,`password` are Required']);
		}	
	}

	public function api_register()
	{
		if ($this->input->post('name') && $this->input->post('business') && $this->input->post('email') && $this->input->post('country') && $this->input->post('password')) {
			$old = $this->db->get_where('provider',['email' => $this->input->post('email'),'df' => ''])->row_array();
			if (!$old) {
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
				retJson(['_return' => false,'msg' => 'Email is already assigned with another user.']);
			}
		}else{
			retJson(['_return' => false,'msg' => '`name`,`business`,`email`,`country`,`password` are Required']);
		}
	}
}