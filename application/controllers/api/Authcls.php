<?php
class Authcls extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function update_email()
	{
		if ($this->input->post('user') && $this->input->post('email')) {
			$this->db->where('id',$this->input->post('user'))->update('register_agent',
				[
					'email'	=> $this->input->post('email')
				]
			);

			retJson(['_return' => true,'msg' => 'Email updated','user' => $this->agent_model->get($this->input->post('user'))]);
		}else{
			retJson(['_return' => false,'msg' => '`email`,`user` are Required']);
		}
	}

	public function update_phone()
	{
		if ($this->input->post('user') && $this->input->post('phone')) {
			$this->db->where('id',$this->input->post('user'))->update('register_agent',
				[
					'phone'	=> $this->input->post('phone')
				]
			);

			retJson(['_return' => true,'msg' => 'Mobile no. updated','user' => $this->agent_model->get($this->input->post('user'))]);
		}else{
			retJson(['_return' => false,'msg' => '`phone`,`user` are Required']);
		}
	}

	public function verify_phone_update()
	{
		if ($this->input->post('user') && $this->input->post('phone')) {
			$user = $this->db->get_where('register_agent',['id !=' => $this->input->post('user'),'phone' => $this->input->post('phone')])->row_object();
			if ($user) {
				retJson(['_return' => false,'msg' => 'This Mobile no. already assigned with another user.']);		
			}else{
				$phone = mt_rand(111111,999999);
				if ($this->input->post('hardsms')) {
					@$this->general_model->sendSms($this->input->post('phone'),'Phone Verification Code is : '.$phone,6);
				}else{
					@$this->general_model->nigeriaBulkSms($this->input->post('phone'),'Phone Verification Code is : '.$phone);
				}
				retJson(['_return' => true,'msg' => 'phone-'.$phone,'phone_code' => $phone]);
			}
		}else{
			retJson(['_return' => false,'msg' => '`phone`,`user` are Required']);
		}	
	}

	public function verify_email_update()
	{
		if ($this->input->post('user') && $this->input->post('email')) {
			$user = $this->db->get_where('register_agent',['id !=' => $this->input->post('user'),'email' => $this->input->post('email')])->row_object();
			if ($user) {
				retJson(['_return' => false,'msg' => 'This Email already assigned with another user.']);		
			}else{
				$mail = mt_rand(111111,999999);
				$template = $this->load->view('mail/verification_code',['code' => $mail],true);
				@$this->general_model->send_mail($this->input->post('email'),'Email Verification Code',$template);
				retJson(['_return' => true,'msg' => 'email-'.$mail,'email_code' => $mail]);
			}
		}else{
			retJson(['_return' => false,'msg' => '`email`,`user` are Required']);
		}	
	}

	public function business_update()
	{
		if($this->input->post('user') && $this->input->post('bname') && $this->input->post('bank') && $this->input->post('bankac')){ 

			$this->db->where('user',$this->input->post('user'))->update('details_agent',
				[
					'bankac'	=> $this->input->post('bankac'),
					'bank'		=> $this->input->post('bank')	
				]
			);

			$this->db->where('id',$this->input->post('user'))->update('register_agent',
				[
					'business'	=> $this->input->post('bname')
				]
			);


			retJson(['_return' => true,'msg' => 'Business Details Saved','user' => $this->agent_model->get($this->input->post('user'))]);
		}else{
			retJson(['_return' => false,'msg' => '`user`,`bname`,`bank`,`bankac` are Required']);
		}
	}

	public function address_update()
	{
		if($this->input->post('user') && $this->input->post('fileaddress') && $this->input->post('address')){
			$old = $this->db->get_where('details_agent',['user' => $this->input->post('user')])->row_object();
			if ($this->input->post('fileaddress')) {
	    		$img = $this->input->post('fileaddress');
	    		$img = str_replace('data:image/png;base64,', '', $img);
				$img = str_replace(' ', '+', $img);
				$data = base64_decode($img);
				$fileaddress = microtime(true).'.png';
				file_put_contents('./uploads/agent/'.$fileaddress, $data);

				if(file_exists(FCPATH.'/uploads/agent/'.$old->fileaddress)) {
	    			@unlink(FCPATH.'/uploads/agent/'.$old->fileaddress);
	    		}
				$this->db->where('user',$this->input->post('user'))->update('details_agent',['fileaddress'	=> $fileaddress]);
				$this->db->where('id',$this->input->post('user'))->update('register_agent',['saddress'	=> '0','status' => '3']);
	    	}

	    	$this->db->where('user',$this->input->post('user'))->update('details_agent',['address'	=> $this->input->post('address')]);

	    	retJson(['_return' => true,'msg' => 'Address Updated','user' => $this->agent_model->get($this->input->post('user'))]);

		}else{
			retJson(['_return' => false,'msg' => '`user`,`fileaddress`,`address` are Required']);
		}
	}

	public function createpin()
	{
		if($this->input->post('user') && $this->input->post('code')){

			$this->db->where('id',$this->input->post('user'))->update('register_agent',['transactionpin' => $this->input->post('code')]);
			retJson(['_return' => true,'msg' => 'Transaction PIN Saved','user' => $this->agent_model->get($this->input->post('user'))]);

		}else{
			retJson(['_return' => false,'msg' => '`user`,`code` are Required']);
		}	
	}

	public function send_account_verification()
	{
		if($this->input->post('user')){
			$user = $this->db->get_where('register_agent',['id' => $this->input->post('user')])->row_object();
			if ($user) {
				$mail = mt_rand(111111,999999);
				$template = $this->load->view('mail/verification_code',['code' => $mail],true);
				@$this->general_model->send_mail($user->email,'Verification Code',$template);
				@$this->general_model->nigeriaBulkSms($user->phone,'Phone Verification Code is : '.$mail);

				retJson(['_return' => true,'msg' => '','code' => $mail]);	
			}else{
				retJson(['_return' => false,'msg' => 'User not found']);	
			}
		}else{
			retJson(['_return' => false,'msg' => '`user` are Required']);
		}	
	}

	public function changepass()
	{
		if($this->input->post('user') && $this->input->post('pass') && $this->input->post('old')){
			$user = $this->db->get_where('register_agent',['id' => $this->input->post('user')])->row_object();
			if ($user) {
				if (md5($this->input->post('old')) == $user->password) {
					$this->db->where('user',$this->input->post('user'))->delete('firebase_agent');	
					$this->db->where('id',$this->input->post('user'))->update('register_agent',['password' => md5($this->input->post('pass'))]);	
					retJson(['_return' => true,'msg' => 'Password Changed.']);			
				}else{
					retJson(['_return' => false,'msg' => 'Old Password do not match']);		
				}
			}else{
				retJson(['_return' => false,'msg' => 'User not found']);	
			}
		}else{
			retJson(['_return' => false,'msg' => '`user`,`pass`,`old` are Required']);
		}	
	}

	public function getuser()
	{
		if($this->input->post('user')){
			retJson(['_return' => true,'user' => $this->agent_model->get($this->input->post('user'))]);
		}else{
			retJson(['_return' => false,'msg' => '`user` are Required']);
		}
	}

	public function logout()
	{
		if ($this->input->post('user') && $this->input->post('token')) {
			$this->db->where('user',$this->input->post('user'))->where('token',$this->input->post('token'))->delete('firebase_agent');
			retJson(['_return' => true,'msg' => 'Logout Success']);	
		}else{
			retJson(['_return' => false,'msg' => '`user`,`token` are Required']);
		}
	}

	public function resetpass()
	{
		if ($this->input->post('user') && $this->input->post('pass')) {
			$this->db->where('id',$this->input->post('user'))->update('register_agent',['password' => md5($this->input->post('pass'))]);
			$this->db->where('user',$this->input->post('user'))->delete('firebase_agent');
			retJson(['_return' => true,'msg' => '']);	
		}else{
			retJson(['_return' => false,'msg' => '`user`,`pass` are Required']);
		}	
	}

	public function forgetpass()
	{
		if ($this->input->post('email')) {
			$user = $this->db->get_where('register_agent',['df' => '','email' => $this->input->post('email')])->row_object();
			if ($user) {
				$mail = mt_rand(111111,999999);
				$template = $this->load->view('mail/verification_code',['code' => $mail],true);
				@$this->general_model->send_mail($this->input->post('email'),'Email Verification Code',$template);
				retJson(['_return' => true,'msg' => 'email-'.$mail,'email_code' => $mail,'userid' => $user->id]);	
			}else{
				retJson(['_return' => false,'msg' => 'Email is not registered']);	
			}
		}else{
			retJson(['_return' => false,'msg' => '`email` are Required']);
		}
	}

	public function send_verification_phone()
	{
		if ($this->input->post('phone')) {
			$phone = mt_rand(111111,999999);
			if ($this->input->post('hardsms')) {
				@$this->general_model->sendSms($this->input->post('phone'),'Phone Verification Code is : '.$phone,6);
			}else{
				@$this->general_model->nigeriaBulkSms($this->input->post('phone'),'Phone Verification Code is : '.$phone);
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
			$user = $this->db->get_where('register_agent',['bvn' => $this->input->post('bvn'),'df' => ''])->row_array();
			if ($user) {
				retJson(['_return' => false,'msg' => 'BVN already assigned with another email.']);
			}else{
				retJson(['_return' => true,'msg' => '']);
			}
		}else{
			retJson(['_return' => false,'msg' => '`bvn` are Required']);
		}	
	}

	public function email_nin_phone_check()
	{
		if ($this->input->post('email') && $this->input->post('nin') && $this->input->post('phone')) {
			$user = $this->db->get_where('register_agent',['email' => $this->input->post('email'),'df' => ''])->row_array();
			if ($user) {
				retJson(['_return' => false,'msg' => 'Email already assigned with another user.']);
			}else{
				$user = $this->db->get_where('details_agent',['nin' => $this->input->post('nin'),'df' => ''])->row_array();
				if ($user) {
					retJson(['_return' => false,'msg' => 'NIN already assigned with another user.']);
				}else{
					$user = $this->db->get_where('register_agent',['phone' => $this->input->post('phone'),'df' => ''])->row_array();
					if ($user) {
						retJson(['_return' => false,'msg' => 'Phone no. already assigned with another user.']);		
					}else{
						retJson(['_return' => true,'msg' => '']);
					}
				}
			}
		}else{
			retJson(['_return' => false,'msg' => '`email`,`nin`,`phone` are Required']);
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
			$user = $this->db->where('df','')->where('email',$this->input->post('email'))->or_where('phone',$this->input->post('email'))->get('register_agent')->row_array();
			//$user = $this->db->get_where('register_agent',['email' => $this->input->post('email'),'df' => ''])->row_array();
			if ($user) {
				if (md5($this->input->post('password')) == $user['password']) {
					if ($user['block'] == "") {
						// if ($user['status'] == "0") {
						// 	retJson(['_return' => false,'result' => 401,'msg' => 'Registration application is still in review']);			
						// }else{
							if ($this->input->post('descr') && $this->input->post('token') && $this->input->post('device') && $this->input->post('device_id')) {
							
								@$this->login_model->firebaseLogin($user['id']);	
								retJson(['_return' => true,'user' => $this->agent_model->get($user['id'])]);

							}else{
								retJson(['_return' => false,'result' => 400,'msg' => '`descr`,`token`,`device_id`,`device` are Required']);
							}	
						//}
					}else{
						retJson(['_return' => false,'result' => 400,'msg' => 'Your account is suspended. Please contact administrator..']);		
					}
				}else{
					retJson(['_return' => false,'result' => 400,'msg' => 'Email/Phone and Password not match']);	
				}
			}else{
				retJson(['_return' => false,'result' => 400,'msg' => 'Email/Phone not registered']);
			}
		}else{
			retJson(['_return' => false,'result' => 400,'msg' => '`email`,`password` are Required']);
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