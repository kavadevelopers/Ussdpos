<?php
class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->auth->check_session();
		$this->load->library('Flutterwave');
	}

	public function test()
	{
		echo ($this->flutterwave->ChargeUSSD(microtime(),'058','10','kava@gmail.com','09096655115','Eva'));
	}

	public function mail()
	{
		//$this->general_model->send_mail('mehul9921@gmail.com','Test','123456');
		//$this->load->view('mail/verification_code');
		echo $this->general_model->sendSms('2348135709201','Veriication code is : 355850');
	}

	public function index()
	{
		$data['_title']		= "Dashboard";
		$data['list']		= $this->dashboard_model->getLatest50Transaction();
		$this->load->theme('dashboard',$data);
	}

	public function push_try()
	{
		$data['_title']		= "Push Try";
		$this->load->theme('push',$data);
	}

	public function send()
	{
		sendPush($this->input->post('device'),[$this->input->post('token')],$this->input->post('title'),$this->input->post('body'),"","");
		$this->session->set_flashdata('msg', 'Sent');
	    redirect(base_url('dashboard/push_try'));
	}
}
?>