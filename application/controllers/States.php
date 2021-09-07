<?php
class States extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->auth->check_session();
		if($this->session->userdata('id') != '1'){
			redirect(base_url('error404'));
		}
	}

	public function delete($id)
	{
		$data = [
			'df'		=> 'yes'
		];
		$this->db->where('id',$id)->update('master_states',$data);

		$this->session->set_flashdata('msg', 'State Deleted');
		redirect(base_url('states/list'));
	}

	public function list()
	{
		$data['_title']		= "Manage States";
		$data['list']	= $this->db->get_where('master_states',['df' => ''])->result_array();
		$data['_e']		= "0";
		$this->load->theme('master/states',$data);
	}

	public function edit($id)
	{
		$data['_title']		= "Manage States";
		$data['list']	= $this->db->get_where('master_states',['df' => ''])->result_array();
		$data['item']	= $this->db->get_where('master_states',['id' => $id])->row_object();
		$data['_e']		= "1";
		$this->load->theme('master/states',$data);
	}

	public function save()
	{
		$data = [
			'name'		=> $this->input->post('name'),
			'df'		=> ''
		];
		$this->db->insert('master_states',$data);

		$this->session->set_flashdata('msg', 'State Added');
		redirect(base_url('states/list'));
	}


	public function update()
	{
		$data = [
			'name'		=> $this->input->post('name')
		];
		$this->db->where('id',$this->input->post('id'))->update('master_states',$data);

		$this->session->set_flashdata('msg', 'State Saved');
		redirect(base_url('states/list'));
	}
}