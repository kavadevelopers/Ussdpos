<?php
class Register extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function agent()
	{
		if($this->input->post('bvn') && $this->input->post('name') && $this->input->post('gender') && $this->input->post('phone') && $this->input->post('email') && $this->input->post('password') && $this->input->post('bname') && $this->input->post('bankac') && $this->input->post('bank') && $this->input->post('nin') && $this->input->post('emp')  && $this->input->post('agent') && $this->input->post('state') && $this->input->post('city') && $this->input->post('address') && $this->input->post('idtype') && $this->input->post('idnum')){

			$old = $this->db->get_where('register_agent',['email' => $this->input->post('email'),'password' => md5($this->input->post('password'))])->row_object()
			if ($old) {
				retJson(['_return' => true,'msg' => 'Registration Success.']);
			}else{
				$config['upload_path'] = './uploads/agent/';
			    $config['allowed_types']	= '*';
			    $config['max_size']      = '0';
			    $config['overwrite']     = TRUE;
			    $this->load->library('upload', $config);

			    if($this->input->post('phone')[0] == "0"){
			    	$phone = ltrim($this->input->post('phone'),'0');
			    }else{
			    	$phone = ltrim($this->input->post('phone'));
			    }

			    $data = [
			    	'bvn'					=> $this->input->post('bvn'),
			    	'name'					=> $this->input->post('name'),
			    	'gender'				=> $this->input->post('gender'),
			    	'phone'					=> $this->input->post('phone'),
			    	'email'					=> $this->input->post('email'),
			    	'password'				=> md5($this->input->post('password')),
			    	'business'				=> $this->input->post('bname'),
			    	'bvn'					=> $this->input->post('bvn'),
			    	'block'					=> '',
			    	'df'					=> '',
			    	'cat'					=> _nowDateTime()
			    ];
			    $this->db->insert('register_agent',$data);
			    $agent = $this->db->insert_id();

		    	if ($this->input->post('fileaddress')) {
		    		$img = $this->input->post('fileaddress');
		    		$img = str_replace('data:image/png;base64,', '', $img);
					$img = str_replace(' ', '+', $img);
					$data = base64_decode($img);
					$fileaddress = microtime(true).'.png';
					file_put_contents('./uploads/agent/'.$fileaddress, $data);
		    	}else{
		    		$fileaddress = "";
		    	}

		    	if ($this->input->post('fileid')) {
		    		$img = $this->input->post('fileid');
		    		$img = str_replace('data:image/png;base64,', '', $img);
					$img = str_replace(' ', '+', $img);
					$data = base64_decode($img);
					$fileid = microtime(true).'.png';
					file_put_contents('./uploads/agent/'.$fileid, $data);
		    	}else{
		    		$fileid = "";
		    	}

		    	if ($this->input->post('fileprofile')) {
		    		$img = $this->input->post('fileprofile');
		    		$img = str_replace('data:image/png;base64,', '', $img);
					$img = str_replace(' ', '+', $img);
					$data = base64_decode($img);
					$fileprofile = microtime(true).'.png';
					file_put_contents('./uploads/agent/'.$fileprofile, $data);
		    	}else{
		    		$fileprofile = "";
		    	}

			    $data = [
			    	'user'					=> $agent,
			    	'bankac'				=> $this->input->post('bankac'),
			    	'bank'					=> $this->input->post('bank'),
			    	'nin'					=> $this->input->post('nin'),
			    	'emp'					=> $this->input->post('emp'),
			    	'agent'					=> $this->input->post('agent'),
			    	'state'					=> $this->input->post('state'),
			    	'city'					=> $this->input->post('city'),
			    	'address'				=> $this->input->post('address'),
			    	'idtype'				=> $this->input->post('idtype'),
			    	'idnum'					=> $this->input->post('idnum'),
			    	'fileaddress'			=> $fileaddress,
			    	'fileid'				=> $fileid,
			    	'fileprofile'			=> $fileprofile
			    ];
			    $this->db->insert('details_agent',$data);

			    $template = $this->load->view('mail/registration_success',[],true);
				@$this->general_model->send_mail($this->input->post('email'),'Registration Success',$template);

			    retJson(['_return' => true,'msg' => 'Registration Success.']);
			}

		}else{
			retJson(['_return' => false,'msg' => '`bvn`,`name`,`gender`,`phone`,`email`,`password`,`bname`,`bankac`,`bank`,`nin`,`emp`,`agent`,`state`,`city`,`address`,`idtype`,`idnum` are Required']);
		}
	}
}