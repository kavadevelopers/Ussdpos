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
			retJson(['_return' => true,'user' => $this->agent_model->get($this->input->post('user'))]);
		}else{
			retJson(['_return' => false,'msg' => '`user` are Required']);
		}
	}

	public function send_verification_phone()
	{
		if ($this->input->post('phone')) {
			$phone = mt_rand(111111,999999);
			if ($this->input->post('hardsms')) {
				@$this->general_model->sendSms($this->input->post('phone'),'Phone Verification Code is : '.$phone,6);
			}else{
				@$this->general_model->sendSms($this->input->post('phone'),'Phone Verification Code is : '.$phone);
			}
			retJson(['_return' => true,'msg' => 'phone-'.$phone,'phone_code' => $phone]);
		}else{
			retJson(['_return' => false,'msg' => '`email`,`phone` are Required']);
		}	
	}

	public function send_verification_email()
	{
		if ($this->input->post('email')) {
			$mail = mt_rand(111111,999999);
			$template = $this->load->view('mail/verification_code',['code' => $mail],true);
			@$this->general_model->send_mail($this->input->post('email'),'Email Verification Code',$template);
			retJson(['_return' => true,'msg' => 'email-'.$mail,'email_code' => $mail]);
		}else{
			retJson(['_return' => false,'msg' => '`email` are Required']);
		}			
	}

	public function bvncheck()
	{
		if ($this->input->post('bvn')) {
			$user = $this->db->get_where('register_agent',['bvn' => $this->input->post('bvn')])->row_array();
			if ($user) {
				retJson(['_return' => false,'msg' => 'BVN already assigned with another email.']);
			}else{
				retJson(['_return' => true,'msg' => '']);
			}
		}else{
			retJson(['_return' => false,'msg' => '`bvn` are Required']);
		}	
	}

	public function emailcheck()
	{
		if ($this->input->post('email')) {
			$user = $this->db->get_where('register_agent',['email' => $this->input->post('email')])->row_array();
			if ($user) {
				retJson(['_return' => false,'msg' => 'Email already assigned with another user.']);
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
							retJson(['_return' => true,'user' => $this->agent_model->get($user['id'])]);
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