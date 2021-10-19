<?php
class Orders extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->auth->check_session();
		$this->rights->redirect([6]);
	}


	public function list()
	{
		$data['_title']		= "POS Orders";
		$this->db->order_by('id','desc');
		$data['list']		= $this->db->get('orders')->result_object();
		$this->load->theme('orders/list',$data);	
	}

	public function view($id)
	{
		$data['_title']		= "POS Orders";
		$data['item']		= $this->db->get_where('orders',['id' => $id])->row_object();
		$this->load->theme('orders/view',$data);	
	}
}