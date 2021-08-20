<?php
class Banks extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->auth->check_session();
		if($this->session->userdata('id') != '1'){
			redirect(base_url('error404'));
		}
	}

	public function ussd()
	{
		$data['_title']		= "Manage Ussd Banks";
		$data['list']	= $this->db->get_where('master_banks',['df' => '','type' => 'ussd'])->result_array();
		$data['_e']		= "0";
		$this->load->theme('master/banks/ussd',$data);
	}

	public function transfer()
	{
		$data['_title']		= "Manage Transfer Banks";
		$data['list']	= $this->db->get_where('master_banks',['df' => '','type' => 'transfer'])->result_array();
		$data['_e']		= "0";
		$this->load->theme('master/banks/transfer',$data);
	}

	public function edit_ussd($id)
	{
		$data['_title']		= "Manage Ussd Banks";
		$data['list']	= $this->db->get_where('master_banks',['df' => '','type' => 'ussd'])->result_array();
		$data['item']	= $this->db->get_where('master_banks',['id' => $id])->row_object();
		$data['_e']		= "1";
		$this->load->theme('master/banks/ussd',$data);
	}

	public function edit_transfer($id)
	{
		$data['_title']		= "Manage Transfer Banks";
		$data['list']	= $this->db->get_where('master_banks',['df' => '','type' => 'transfer'])->result_array();
		$data['item']	= $this->db->get_where('master_banks',['id' => $id])->row_object();
		$data['_e']		= "1";
		$this->load->theme('master/banks/transfer',$data);
	}

	public function save_ussd()
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
			'type'		=> 'ussd',
			'df'		=> ''
		];
		$this->db->insert('master_banks',$data);

		$this->session->set_flashdata('msg', 'Bank Added');
		redirect(base_url('banks/ussd'));
	}

	public function save_transfer()
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
			'type'		=> 'transfer',
			'df'		=> ''
		];
		$this->db->insert('master_banks',$data);

		$this->session->set_flashdata('msg', 'Bank Added');
		redirect(base_url('banks/transfer'));
	}

	public function update_ussd()
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
	    		$old = $this->db->get_where('master_banks',['id' => $this->input->post('id')])->row_array();
	    		if(file_exists(FCPATH.'/uploads/master/'.$old['image'])){
	    			@unlink(FCPATH.'/uploads/master/'.$old['image']);
	    		}
	    		$data = [
					'image'		=> $file_name
				];
				$this->db->where('id',$this->input->post('id'))->update('master_banks',$data);
	    	}
		}

		$data = [
			'name'		=> $this->input->post('name'),
			'bcode'		=> $this->input->post('bcode')
		];
		$this->db->where('id',$this->input->post('id'))->update('master_banks',$data);

		$this->session->set_flashdata('msg', 'Bank Updated');
		redirect(base_url('banks/ussd'));
	}

	public function update_transfer()
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
	    		$old = $this->db->get_where('master_banks',['id' => $this->input->post('id')])->row_array();
	    		if(file_exists(FCPATH.'/uploads/master/'.$old['image'])){
	    			@unlink(FCPATH.'/uploads/master/'.$old['image']);
	    		}
	    		$data = [
					'image'		=> $file_name
				];
				$this->db->where('id',$this->input->post('id'))->update('master_banks',$data);
	    	}
		}

		$data = [
			'name'		=> $this->input->post('name'),
			'bcode'		=> $this->input->post('bcode')
		];
		$this->db->where('id',$this->input->post('id'))->update('master_banks',$data);

		$this->session->set_flashdata('msg', 'Bank Updated');
		redirect(base_url('banks/transfer'));
	}

	public function delete($id,$type)
	{
		$this->db->where('id',$id)->update('master_banks',['df' => 'yes']);
		$this->session->set_flashdata('msg', 'Bank Deleted');
		redirect(base_url('banks/'.$type));
	}
}