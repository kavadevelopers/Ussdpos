<?php
class Other extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->auth->check_session();
	}


	public function send_app_notification()
	{
		$this->rights->redirect([1]);
		$data['_title']		= "Send Push Notifications To mobile devices";
		$this->load->theme('other/push_notification',$data);	
	}

	public function send_pushnotification()
	{
		$atokens = []; $itokens = [];
		if($this->input->post('user_type') == "customer"){
			$users = $this->db->select('token')->where('df','')->where('token !=','')->get('z_customer')->result_array();
			foreach ($users as $key => $value) {
				array_push($tokens, $value['token']);
			}
		}

		$androidUsers = $this->db->select('token')->where('token !=','')->where('device','android')->get('firebase_agent')->result_array();
		foreach ($androidUsers as $key => $value) {
			array_push($atokens, $value['token']);
		}
		$iosUsers = $this->db->select('token')->where('token !=','')->where('device','iOS')->get('firebase_agent')->result_array();
		foreach ($iosUsers as $key => $value) {
			array_push($itokens, $value['token']);
		}

		$a = $this->general_model->sendNotificationsToAndroidDevices(
			$atokens,
			$this->input->post('title'),
			$this->input->post('message')
		);
		
		$this->session->set_flashdata('msg', 'Notifications Sent');
		redirect(base_url('other/send_app_notification'));
	}
}