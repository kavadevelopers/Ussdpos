<?php
class General extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getbanks()
	{
		if ($this->input->post('type')) {
			
			$this->db->where('type',$this->input->post('type'));
			$this->db->where('df',"");
			$query = $this->db->get('master_banks');


			$list = $query->result_object();
			foreach ($list as $key => $value) {
				$value->image = $this->general_model->getBankThumb($value->id);
			}

			retJson(['_return' => true,'count' => $query->num_rows(),'list' => $list]);

		}else{
			retJson(['_return' => false,'msg' => '`type` are Required']);
		}
	}

	public function getpage()
	{
		$settings = [
			'_return'			=> true,
			'content'			=> $this->db->get_where('cms_pages',['id' => $this->input->post('page')])->row_object()->descr
		];

		retJson($settings);	
	}

	public function getsettings()
	{
		$settings = [
			'_return'		=> true,
			'android_ver'	=> get_setting()['android_ver'],
			'ios_ver'		=> get_setting()['ios_ver'],
			'terms'			=> $this->db->get_where('cms_pages',['id' => '1'])->row_object()->descr,
			'msg'			=> '`user`,`firetoken` are Optional'
		];

		if ($this->input->post('user')) {
			$isLoggedIn = $this->db->get_where('service_firebase',['user' => $this->input->post('user'),'token' => $this->input->post('token')])->row_object();
			if ($isLoggedIn) {
				$settings['isLoggedIn'] = "1";
			}else{
				$settings['isLoggedIn'] = "0";
			}
		}

		retJson($settings);
	}


	public function agent_uploaddoc()
	{
		if($this->input->post('user')){
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
				$this->db->where('id',$this->input->post('user'))->update('register_agent',['saddress'	=> '0']);
	    	}

	    	if ($this->input->post('fileid')) {
	    		$img = $this->input->post('fileid');
	    		$img = str_replace('data:image/png;base64,', '', $img);
				$img = str_replace(' ', '+', $img);
				$data = base64_decode($img);
				$fileid = microtime(true).'.png';
				file_put_contents('./uploads/agent/'.$fileid, $data);
				if(file_exists(FCPATH.'/uploads/agent/'.$old->fileid)) {
	    			@unlink(FCPATH.'/uploads/agent/'.$old->fileid);
	    		}
				$this->db->where('user',$this->input->post('user'))->update('details_agent',['fileid'	=> $fileid]);
				$this->db->where('id',$this->input->post('user'))->update('register_agent',['sid'	=> '0']);
	    	}

	    	if ($this->input->post('fileprofile')) {
	    		$img = $this->input->post('fileprofile');
	    		$img = str_replace('data:image/png;base64,', '', $img);
				$img = str_replace(' ', '+', $img);
				$data = base64_decode($img);
				$fileprofile = microtime(true).'.png';
				file_put_contents('./uploads/agent/'.$fileprofile, $data);
				if(file_exists(FCPATH.'/uploads/agent/'.$old->fileprofile)) {
	    			@unlink(FCPATH.'/uploads/agent/'.$old->fileprofile);
	    		}
				$this->db->where('user',$this->input->post('user'))->update('details_agent',['fileprofile'	=> $fileprofile]);
				$this->db->where('id',$this->input->post('user'))->update('register_agent',['sphoto'	=> '0']);
	    	}

	    	$this->db->where('id',$this->input->post('user'))->update('register_agent',['status'	=> '3']);


			retJson(['_return' => true,'msg' => 'Images Uploaded','user' => $this->agent_model->get($this->input->post('user'))]);
		}else{
			retJson(['_return' => false,'msg' => '`user` are Required']);
		}
	}
}