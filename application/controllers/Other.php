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
		//print_r($_POST);exit;	
		if (!$id) {
			if ($this->input->post('group') == "User") {
				if ($this->input->post('users')) {
					$usersStr = implode(',', $this->input->post('users'));
				}else{
					$usersStr = "";
				}	
			}else{
				$usersStr = "";
			}
			
			$data = [
				'title'			=>	$this->input->post('title'),
				'body'			=>	$this->input->post('message'),
				'type'			=> 	$this->input->post('group'),
				'users'			=>	$usersStr
			];
			$this->db->insert('custom_notifications',$data);
			$old = $this->db->get_where('custom_notifications',['id' => $this->db->insert_id()])->row_object();
		}else{
			$old = $this->db->get_where('custom_notifications',['id' => $id])->row_object();
		}


		if ($old->type == "Active") {
			$atokens = [];
			$this->db->select('id');
			$regUsersActive = $this->db->get_where('register_agent',['df' => '','status' => '1'])->result_object();
			$arrayIds = [];
			foreach ($regUsersActive as $key => $value) {
				array_push($arrayIds, $value->id);
			}
			$androidUsers = $this->db->select('token')->where('token !=','')->where('device','android')->where_in('user',$arrayIds)->get('firebase_agent')->result_array();
			foreach ($androidUsers as $key => $value) {
				array_push($atokens, $value['token']);
			}
			$iosUsers = $this->db->select('token')->where('token !=','')->where('device','iOS')->where_in('user',$arrayIds)->get('firebase_agent')->result_array();
			foreach ($iosUsers as $key => $value) {
				array_push($itokens, $value['token']);
			}
		}else if ($old->type == "Processing") {
			$atokens = [];
			$this->db->select('id');
			$regUsersActive = $this->db->get_where('register_agent',['df' => '','status' => '2'])->result_object();
			$arrayIds = [];
			foreach ($regUsersActive as $key => $value) {
				array_push($arrayIds, $value->id);
			}
			$androidUsers = $this->db->select('token')->where('token !=','')->where('device','android')->where_in('user',$arrayIds)->get('firebase_agent')->result_array();
			foreach ($androidUsers as $key => $value) {
				array_push($atokens, $value['token']);
			}
			$iosUsers = $this->db->select('token')->where('token !=','')->where('device','iOS')->where_in('user',$arrayIds)->get('firebase_agent')->result_array();
			foreach ($iosUsers as $key => $value) {
				array_push($itokens, $value['token']);
			}
		}else if ($old->type == "ReUploaded") {
			$atokens = [];
			$this->db->select('id');
			$regUsersActive = $this->db->get_where('register_agent',['df' => '','status' => '3'])->result_object();
			$arrayIds = [];
			foreach ($regUsersActive as $key => $value) {
				array_push($arrayIds, $value->id);
			}
			$androidUsers = $this->db->select('token')->where('token !=','')->where('device','android')->where_in('user',$arrayIds)->get('firebase_agent')->result_array();
			foreach ($androidUsers as $key => $value) {
				array_push($atokens, $value['token']);
			}
			$iosUsers = $this->db->select('token')->where('token !=','')->where('device','iOS')->where_in('user',$arrayIds)->get('firebase_agent')->result_array();
			foreach ($iosUsers as $key => $value) {
				array_push($itokens, $value['token']);
			}
		}else if ($old->type == "Pending") {
			$atokens = [];
			$this->db->select('id');
			$regUsersActive = $this->db->get_where('register_agent',['df' => '','status' => '0'])->result_object();
			$arrayIds = [];
			foreach ($regUsersActive as $key => $value) {
				array_push($arrayIds, $value->id);
			}
			$androidUsers = $this->db->select('token')->where('token !=','')->where('device','android')->where_in('user',$arrayIds)->get('firebase_agent')->result_array();
			foreach ($androidUsers as $key => $value) {
				array_push($atokens, $value['token']);
			}
			$iosUsers = $this->db->select('token')->where('token !=','')->where('device','iOS')->where_in('user',$arrayIds)->get('firebase_agent')->result_array();
			foreach ($iosUsers as $key => $value) {
				array_push($itokens, $value['token']);
			}
		}else{
			$atokens = [];
			if ($old->users != "") {

				$androidUsers = $this->db->select('token')->where('token !=','')->where('device','android')->where_in('user',explode(',', $old->users))->get('firebase_agent')->result_array();




				foreach ($androidUsers as $key => $value) {
					array_push($atokens, $value['token']);
				}
				$iosUsers = $this->db->select('token')->where('token !=','')->where('device','iOS')->where_in('user',explode(',', $old->users))->get('firebase_agent')->result_array();
				foreach ($iosUsers as $key => $value) {
					array_push($itokens, $value['token']);
				}
			}else{
				$androidUsers = $this->db->select('token')->where('token !=','')->where('device','android')->get('firebase_agent')->result_array();
				foreach ($androidUsers as $key => $value) {
					array_push($atokens, $value['token']);
				}
				$iosUsers = $this->db->select('token')->where('token !=','')->where('device','iOS')->get('firebase_agent')->result_array();
				foreach ($iosUsers as $key => $value) {
					array_push($itokens, $value['token']);
				}
			}	
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