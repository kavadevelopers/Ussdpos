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

			$config['upload_path'] = './uploads/agent/';
		    $config['allowed_types']	= '*';
		    $config['max_size']      = '0';
		    $config['overwrite']     = TRUE;
		    $this->load->library('upload', $config);

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


		    if(isset($_FILES ['fileaddress']) && $_FILES['fileaddress']['error'] == 0){
		    	$config['file_name'] = microtime(true).".".pathinfo($_FILES['fileaddress']['name'], PATHINFO_EXTENSION);
		    	$this->upload->initialize($config);
		    	if($this->upload->do_upload('fileaddress')){
		    		$fileaddress = $config['file_name'];
		    	}else{
		    		$fileaddress = "";
		    	}
		    }else{
	    		$fileaddress = "";
	    	}

		    if(isset($_FILES ['fileid']) && $_FILES['fileid']['error'] == 0){
		    	$config['file_name'] = microtime(true).".".pathinfo($_FILES['fileid']['name'], PATHINFO_EXTENSION);
		    	$this->upload->initialize($config);
		    	if($this->upload->do_upload('fileid')){
		    		$fileid = $config['file_name'];
		    	}else{
		    		$fileid = "";
		    	}
		    }else{
	    		$fileid = "";
	    	}
	    	if(isset($_FILES ['fileprofile']) && $_FILES['fileprofile']['error'] == 0){
		    	$config['file_name'] = microtime(true).".".pathinfo($_FILES['fileprofile']['name'], PATHINFO_EXTENSION);
		    	$this->upload->initialize($config);
		    	if($this->upload->do_upload('fileprofile')){
		    		$fileprofile = $config['file_name'];
		    	}else{
		    		$fileprofile = "";
		    	}
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

		    retJson(['_return' => true,'msg' => 'Registration Success.']);
		}else{
			retJson(['_return' => false,'msg' => '`bvn`,`name`,`gender`,`phone`,`email`,`password`,`bname`,`bankac`,`bank`,`nin`,`emp`,`agent`,`state`,`city`,`address`,`idtype`,`idnum` are Required']);
		}
	}
}