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
		$this->db->limit(50);
		$this->db->order_by('id','desc');
		$data['list']		= $this->db->get('custom_notifications')->result_object();
		$this->load->theme('other/push_notification',$data);	
	}

	public function send_pushnotification($id = false)
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

		if (!$id) {
			$data = [
				'title'			=>	$this->input->post('title'),
				'body'			=>	$this->input->post('message')
			];
			$this->db->insert('custom_notifications',$data);
			$old = $this->db->get_where('custom_notifications',['id' => $this->db->insert_id()])->row_object();
		}else{
			$old = $this->db->get_where('custom_notifications',['id' => $id])->row_object();
		}

		$a = $this->general_model->sendNotificationsToAndroidDevices(
			$atokens,
			$old->title,
			$old->body
		);
		
		$this->session->set_flashdata('msg', 'Notifications Sent');
		redirect(base_url('other/send_app_notification'));
	}

	public function delete_push($id)
	{
		$this->db->where('id',$id)->delete('custom_notifications');
		$this->session->set_flashdata('msg', 'Notifications Deleted');
		redirect(base_url('other/send_app_notification'));	
	}
}