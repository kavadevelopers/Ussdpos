<?php
class Commission extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->auth->check_session();
		if($this->session->userdata('id') != '1'){
			redirect(base_url('error404'));
		}
	}

	public function index()
	{
		$data['_title']		= "Commission Settings";
		$this->load->theme('setting/commission',$data);	
	}

	public function save()
	{
		$data = [
			'ussd_type'			=> $this->input->post('ussd_type'),
			'ussd_per'			=> $this->input->post('ussd_per'),
			'ussd_fix'			=> $this->input->post('ussd_fix'),
			'fussd_type'		=> $this->input->post('fussd_type'),
			'fussd_per'			=> $this->input->post('fussd_per'),
			'fussd_fix'			=> $this->input->post('fussd_fix'),
		];

		$this->db->where('id','1')->update('set_commission',$data);

		$this->session->set_flashdata('msg', 'Commission Saved');
	    redirect(base_url('commission'));
	}
}