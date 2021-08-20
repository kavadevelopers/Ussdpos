<?php
class Master extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->auth->check_session();
		if($this->session->userdata('id') != '1'){
			redirect(base_url('error404'));
		}
	}


	public function banks()
	{
		$data['_title']		= "Manage Banks";
		$data['list']	= $this->db->get_where('master_banks',['df' => ''])->result_array();
		$data['_e']		= "0";
		$this->load->theme('master/banks',$data);
	}

	public function save_bank()
	{
		$config['upload_path'] = './uploads/master/';
	    $config['allowed_types']	= '*';
	    $config['max_size']      = '0';
	    $config['overwrite']     = FALSE;
	    $file_name = "";

	    $this->load->library('upload', $config);
	    if (isset($_FILES ['image']) && $_FILES ['image']['error'] == 0) {
			$file_name = microtime(true).".".pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
			$config['file_name'] = $file_name;
	    	$this->upload->initialize($config);
	    	if($this->upload->do_upload('image')){
	    		
	    	}else{
	    		$file_name = "";
	    	}
		}

		$data = [
			'name'		=> $this->input->post('name'),
			'bcode'		=> $this->input->post('bcode'),
			'image'		=> $file_name,
			'df'		=> ''
		];
		$this->db->insert('master_banks',$data);

		$this->session->set_flashdata('msg', 'Bank Added');
		redirect(base_url('master/banks'));
	}
}