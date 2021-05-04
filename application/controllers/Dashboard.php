<?php
class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->auth->check_session();
	}

	public function index()
	{
		$data['_title']		= "Dashboard";
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