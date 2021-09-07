<?php
class Regbanks extends CI_Controller
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
		$this->db->where('id',$id)->update('master_reg_banks',$data);

		$this->session->set_flashdata('msg', 'Bank Deleted');
		redirect(base_url('regbanks/banks'));
	}

	public function edit($id)
	{
		$data['_title']		= "Manage Registration Banks";
		$data['list']	= $this->db->get_where('master_reg_banks',['df' => ''])->result_array();
		$data['item']	= $this->db->get_where('master_reg_banks',['id' => $id])->row_object();
		$data['_e']		= "1";
		$this->load->theme('master/regbanks',$data);
	}

	public function banks()
	{
		$data['_title']		= "Manage Registration Banks";
		$data['list']	= $this->db->get_where('master_reg_banks',['df' => ''])->result_array();
		$data['_e']		= "0";
		$this->load->theme('master/regbanks',$data);
	}

	public function save()
	{
		$data = [
			'name'		=> $this->input->post('name'),
			'df'		=> ''
		];
		$this->db->insert('master_reg_banks',$data);

		$this->session->set_flashdata('msg', 'Bank Added');
		redirect(base_url('regbanks/banks'));
	}

	public function update()
	{
		$data = [
			'name'		=> $this->input->post('name')
		];
		$this->db->where('id',$this->input->post('id'))->update('master_reg_banks',$data);

		$this->session->set_flashdata('msg', 'Bank Saved');
		redirect(base_url('regbanks/banks'));
	}
}