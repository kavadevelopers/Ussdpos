<?php
class Common extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->auth->check_session();
		if($this->session->userdata('id') != '1'){
			redirect(base_url('error404'));
		}
	}


	public function delivery()
	{
		$data['_title']		= 	"POS Delivery Charges";
		$data['charge']		=	$this->db->get_where('order_delivery_charges',['id' => '1'])->row_array(); 
		$this->load->theme('common/delivery',$data);
	}

	public function save_delivery()
	{
		$data = [
			'gig'			=> $this->input->post('gig'),
			'gigcash'		=> $this->input->post('gigcash'),
			'bus'			=> $this->input->post('bus'),
			'buscash'		=> $this->input->post('buscash'),
			'per'			=> $this->input->post('per'),
			'percash'		=> $this->input->post('percash')
		];

		$this->db->where('id','1')->update('order_delivery_charges',$data);
		$this->session->set_flashdata('msg', 'Settings Saved');
	    redirect(base_url('common/delivery'));
	}
}