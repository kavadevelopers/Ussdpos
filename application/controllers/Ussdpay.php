<?php
class Ussdpay extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->auth->check_session();
		$this->rights->redirect([4]);
	}


	public function pending()
	{
		$data['_title']		= "Pending USSD Payments";		
		$this->db->order_by('id','desc');
		$data['list']		= $this->db->get_where('payment_ussd',['status' => '0'])->result_object();
		$this->load->theme('payments/ussd/list',$data);	
	}

	public function success()
	{
		$data['_title']		= "Success USSD Payments";		
		$this->db->order_by('id','desc');
		$data['list']		= $this->db->get_where('payment_ussd',['status' => '1'])->result_object();
		$this->load->theme('payments/ussd/list',$data);	
	}

	public function failed()
	{
		$data['_title']		= "Failed USSD Payments";		
		$this->db->order_by('id','desc');
		$data['list']		= $this->db->get_where('payment_ussd',['status' => '2'])->result_object();
		$this->load->theme('payments/ussd/list',$data);		
	}
}