<?php
class Authcls extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getuser()
	{
		if($this->input->post('user')){
			retJson(['_return' => true,'user' => $this->general_model->getUser($this->input->post('user'))]);
		}else{
			retJson(['_return' => false,'msg' => '`user` are Required']);
		}
	}

	public function emailcheck()
	{
		if ($this->input->post('email')) {
			$user = $this->db->get_where('register_agent',['email' => $this->input->post('email'),'df' => ''])->row_array();
			if ($user) {
				retJson(['_return' => false,'msg' => 'Email already assigned with another email.']);
			}else{
				retJson(['_return' => true,'msg' => '']);
			}
		}else{
			retJson(['_return' => false,'msg' => '`email` are Required']);
		}	
	}

	public function login()
	{
		if ($this->input->post('email') && $this->input->post('password')) {
			$user = $this->db->get_where('register_agent',['email' => $this->input->post('email'),'df' => ''])->row_array();
			if ($user) {
				if (md5($this->input->post('password')) == $user['password']) {
					if ($user['block'] == "") {
						if ($this->input->post('descr') && $this->input->post('token') && $this->input->post('device') && $this->input->post('device_id')) {
							@$this->login_model->firebaseLogin($user['id']);	
							retJson(['_return' => true,'user' => $this->general_model->getUser($user['id'])]);
						}else{
							retJson(['_return' => false,'msg' => '`descr`,`token`,`device_id`,`device` are Required']);
						}	
					}else{
						retJson(['_return' => false,'msg' => 'Your account is suspended. Please contact administrator..']);		
					}
				}else{
					retJson(['_return' => false,'msg' => 'Email and Password not match']);	
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