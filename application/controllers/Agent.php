<?php
class Agent extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->auth->check_session();
		$this->rights->redirect([3]);
	}

	public function reset_password()
	{
		$this->db->where('id',$this->input->post('id'))->update('register_agent',['password' => md5($this->input->post('pass'))]);
		$this->session->set_flashdata('msg', 'Password has been changed');
	    redirect(base_url('agent/'.$this->input->post('route')));
	}

	public function doc_status()
	{
		$processing = 0; $photo = 1; $idphoto = 1; $address = 1;
		$agent = $this->db->get_where('register_agent',['id' => $this->input->post('agent')])->row_object();
		if ($this->input->post('photos_status') == '0') {
			$smsTemp = "Your Passport Photograph Verification has been rejected. Reason - ".$this->input->post('photo_reason').", Please login and reupload a new Passport Photo";

			

			@$this->general_model->agentPush(
				$this->input->post('agent'),
				'Passport photo rejected',
				$smsTemp
			);

			$template = $this->load->view('mail/verification/photo',[
				'reason'	=> $this->input->post('photo_reason')
			],true);
			@$this->general_model->send_mail($agent->email,'Passport photo rejected',$template);
			@$this->general_model->nigeriaBulkSms($agent->phone,$smsTemp);
			$processing++;
			$photo = 2;
		}

		if ($this->input->post('id_status') == '0') {
			$smsTemp = "Your Proof of Identity Verification has been rejected. Reason - ".$this->input->post('id_reason').", Please login and reupload a new Proof of Identification";
			@$this->general_model->agentPush(
				$this->input->post('agent'),
				'ID Photo rejected',
				$smsTemp
			);


			$template = $this->load->view('mail/verification/id',[
				'reason'	=> $this->input->post('id_reason')
			],true);
			@$this->general_model->send_mail($agent->email,'ID Photo rejected',$template);
			@$this->general_model->nigeriaBulkSms($agent->phone,$smsTemp);
			$processing++;
			$idphoto = 2;
		}

		if ($this->input->post('address_status') == '0') {
			$smsTemp = "Your Address Verification has been rejected. Reason - ".$this->input->post('address_reason').", Please login and reupload a new proof of address";
			@$this->general_model->agentPush(
				$this->input->post('agent'),
				'Address Verification rejected',
				$smsTemp
			);


			$template = $this->load->view('mail/verification/address',[
				'reason'	=> $this->input->post('address_reason')
			],true);
			@$this->general_model->send_mail($agent->email,'Address Verification rejected',$template);
			@$this->general_model->nigeriaBulkSms($agent->phone,$smsTemp);
			$processing++;
			$address = 2;
		}

		if ($processing == 0) {
			$approved = 1;
		}else{
			$approved = 2;
		}

		$data = [
			'status'	=> $approved,
			'sphoto'	=> $photo,
			'sid'		=> $idphoto,
			'saddress'	=> $address
		];

		$this->db->where('id',$this->input->post('agent'))->update('register_agent',$data);

		if ($approved == 1) {
			$smsTemp = "Your account information has been verified and approved, please  proceed to using enjoying our services such instant bank alert and ordering POS terminals";
			@$this->general_model->agentPush(
				$this->input->post('agent'),
				'Document Verification Success',
				$smsTemp
			);
			@$this->general_model->nigeriaBulkSms($agent->phone,$smsTemp);
			$template = $this->load->view('mail/registration_success',[
				
			],true);
			@$this->general_model->send_mail($agent->email,'Document Verification Success',$template);
		}

		$this->session->set_flashdata('msg', 'Agent Status has been changed');
	    redirect(base_url('agent/view/'.$this->input->post('agent').'/'.$this->input->post('uri')));
	}

	public function update()
	{
		$data = [
	    	'bvn'					=> $this->input->post('bvn'),
	    	'name'					=> $this->input->post('name'),
	    	'gender'				=> $this->input->post('gender'),
	    	'phone'					=> $this->input->post('phone'),
	    	'email'					=> $this->input->post('email'),
	    	'business'				=> $this->input->post('business')
	    ];
	    $this->db->where('id',$this->input->post('main'))->update('register_agent',$data);

	    $data = [
	    	'bankac'				=> $this->input->post('bankac'),
	    	'bank'					=> $this->input->post('bank'),
	    	'nin'					=> $this->input->post('nin'),
	    	'emp'					=> $this->input->post('emp'),
	    	'agent'					=> $this->input->post('agent'),
	    	'state'					=> $this->input->post('state'),
	    	'city'					=> $this->input->post('city'),
	    	'address'				=> $this->input->post('address'),
	    	'idtype'				=> $this->input->post('idtype'),
	    	'idnum'					=> $this->input->post('idnum')
	    ];
	    $this->db->where('user',$this->input->post('main'))->update('details_agent',$data);


	    $config['upload_path'] = './uploads/agent/';
	    $config['allowed_types']	= '*';
	    $config['max_size']      = '0';
	    $config['overwrite']     = FALSE;
	    $this->load->library('upload', $config);
	    if (isset($_FILES ['photo']) && $_FILES ['photo']['error'] == 0) {
			$file_name = microtime(true).".".pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
			$config['file_name'] = $file_name;
	    	$this->upload->initialize($config);
	    	if($this->upload->do_upload('photo')){
	    		$old = $this->db->get_where('details_agent',['user' => $this->input->post('main')])->row_object();
	    		if(file_exists(FCPATH.'/uploads/agent/'.$old->fileprofile)) {
	    			@unlink(FCPATH.'/uploads/agent/'.$old->fileprofile);
	    		}
	    		$data = [
					'fileprofile'		=> $file_name
				];
				$this->db->where('user',$this->input->post('main'))->update('details_agent',$data);
	    	}
		}

		if (isset($_FILES ['fileaddress']) && $_FILES ['fileaddress']['error'] == 0) {
			$file_name = microtime(true).".".pathinfo($_FILES['fileaddress']['name'], PATHINFO_EXTENSION);
			$config['file_name'] = $file_name;
	    	$this->upload->initialize($config);
	    	if($this->upload->do_upload('fileaddress')){
	    		$old = $this->db->get_where('details_agent',['user' => $this->input->post('main')])->row_object();
	    		if(file_exists(FCPATH.'/uploads/agent/'.$old->fileaddress)) {
	    			@unlink(FCPATH.'/uploads/agent/'.$old->fileaddress);
	    		}
	    		$data = [
					'fileaddress'		=> $file_name
				];
				$this->db->where('user',$this->input->post('main'))->update('details_agent',$data);
	    	}
		}

		if (isset($_FILES ['fileid']) && $_FILES ['fileid']['error'] == 0) {
			$file_name = microtime(true).".".pathinfo($_FILES['fileid']['name'], PATHINFO_EXTENSION);
			$config['file_name'] = $file_name;
	    	$this->upload->initialize($config);
	    	if($this->upload->do_upload('fileid')){
	    		$old = $this->db->get_where('details_agent',['user' => $this->input->post('main')])->row_object();
	    		if(file_exists(FCPATH.'/uploads/agent/'.$old->fileid)) {
	    			@unlink(FCPATH.'/uploads/agent/'.$old->fileid);
	    		}
	    		$data = [
					'fileid'		=> $file_name
				];
				$this->db->where('user',$this->input->post('main'))->update('details_agent',$data);
	    	}
		}

	    $this->session->set_flashdata('msg', 'Agent updated');
	    redirect(base_url('agent/'.$this->input->post('type')));
	}

	public function edit($id,$page = "")
	{
		$data['_title']		= "Edit Agent";	
		$data['page']       = "active";
		if (!empty($page)) {
			$data['page']		= $page;	
		}
		$data['item']		= $this->agent_model->get($id);
		$this->load->theme('appusers/agent/edit',$data);
	}

	public function view($id,$page = "")
	{
		$data['_title']		= "View Agent";	
		$data['page']       = "active";
		if (!empty($page)) {
			$data['page']		= $page;	
		}
		$data['item']		= $this->agent_model->get($id);
		$this->load->theme('appusers/agent/view',$data);
	}

	public function blocked()
	{
		$data['_title']		= "Agents - Blocked/Reported";		
		$this->db->order_by('id','desc');
		$data['list']		= $this->db->get_where('register_agent',['df' => '','block' => 'yes'])->result_object();
		$this->load->theme('appusers/agent/active',$data);	
	}

	public function active()
	{
		$data['_title']		= "Agents - Active";		
		$this->db->order_by('id','desc');
		$data['list']		= $this->db->get_where('register_agent',['df' => '','block' => '','status' => '1'])->result_object();
		$this->load->theme('appusers/agent/active',$data);	
	}

	public function pending()
	{
		$data['_title']		= "Agents - Pending Verification";		
		$this->db->order_by('id','desc');
		$data['list']		= $this->db->get_where('register_agent',['df' => '','block' => '','status' => '0'])->result_object();
		$this->load->theme('appusers/agent/active',$data);	
	}

	public function processing()
	{
		$data['_title']		= "Agents - Processing";		
		$this->db->order_by('id','desc');
		$data['list']		= $this->db->get_where('register_agent',['df' => '','block' => '','status' => '2'])->result_object();
		$this->load->theme('appusers/agent/active',$data);	
	}

	public function reuploaded()
	{
		$data['_title']		= "Agents - Documents Re Uploaded";		
		$this->db->order_by('id','desc');
		$data['list']		= $this->db->get_where('register_agent',['df' => '','block' => '','status' => '3'])->result_object();
		$this->load->theme('appusers/agent/active',$data);	
	}

	public function deleted()
	{
		if($this->session->userdata('id') != '1'){
			redirect(base_url('error404'));
		}
		$data['_title']		= "Agents - Deleted";		
		$this->db->order_by('id','desc');
		$data['list']		= $this->db->get_where('register_agent',['df' => 'yes'])->result_object();
		$this->load->theme('appusers/agent/deleted',$data);	
	}

	public function delete($id,$type)
	{
		if($this->session->userdata('id') != '1'){
			redirect(base_url('error404'));
		}

		$old = $this->db->get_where('details_agent',['user' => $id])->row_object();
		if(file_exists(FCPATH.'/uploads/agent/'.$old->fileprofile)) {
			@unlink(FCPATH.'/uploads/agent/'.$old->fileprofile);
		}

		if(file_exists(FCPATH.'/uploads/agent/'.$old->fileaddress)) {
			@unlink(FCPATH.'/uploads/agent/'.$old->fileaddress);
		}

		if(file_exists(FCPATH.'/uploads/agent/'.$old->fileid)) {
			@unlink(FCPATH.'/uploads/agent/'.$old->fileid);
		}
		
		$this->db->where('id',$id)->update('register_agent',['df' => 'yes']);
		$this->db->where('user',$id)->update('details_agent',['df' => 'yes']);
		$this->session->set_flashdata('msg', 'Agent deleted');
	    redirect(base_url('agent/'.$type));
	}

	public function block($id,$type,$status = false)
	{
		$s = "";
		if($status){ $s = "yes"; }
		$this->db->where('id',$id)->update('register_agent',['block' => $s]);
		$this->session->set_flashdata('msg', 'Status Changed');
	    redirect(base_url('agent/'.$type));
	}

	public function validate_edit()
	{
		$user = $this->db->get_where('register_agent',['bvn' => $this->input->post('bvn'),'id !=' => $this->input->post('main'),'df' => ''])->row_array();
		if ($user) {
			retJson(['_return' => false,'msg' => 'BVN already assigned with another user.']);
		}else{
			$user = $this->db->get_where('register_agent',['phone' => $this->input->post('phone'),'id !=' => $this->input->post('main'),'df' => ''])->row_array();
			if ($user) {
				retJson(['_return' => false,'msg' => 'Phone already assigned with another user.']);
			}else{
				$user = $this->db->get_where('register_agent',['email' => $this->input->post('email'),'id !=' => $this->input->post('main'),'df' => ''])->row_array();
				if ($user) {
					retJson(['_return' => false,'msg' => 'Email already assigned with another user.']);
				}else{
					$user = $this->db->get_where('details_agent',['nin' => $this->input->post('nin'),'user !=' => $this->input->post('main'),'df' => ''])->row_array();
					if ($user) {
						retJson(['_return' => false,'msg' => 'NIN already assigned with another user.']);
					}else{
						retJson(['_return' => true,'msg' => '']);
					}	
				}
			}
		}
	}
}