<?php
class Setting extends CI_Controller
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
		$data['_title']		= "Settings";
		$this->load->theme('setting/index',$data);
	}

	public function save()
	{
		$this->form_validation->set_error_delimiters('<div class="val-error">', '</div>');
		$this->form_validation->set_rules('company', 'Company Name','trim|required');
		$this->form_validation->set_rules('fserverkey', 'Firebase Server Key','trim|required');

		$this->form_validation->set_rules('com_ussd', 'USSD Commmission','trim|required');

		$this->form_validation->set_rules('flutterapi', 'FlutterWave Secret Key','trim|required');
		$this->form_validation->set_rules('flutter_public', 'FlutterWave Public Key','trim|required');
		$this->form_validation->set_rules('flutter_enc_key', 'Encryption Key','trim|required');

		$this->form_validation->set_rules('bulksmskey', 'BulkSMS Nigeria Key','trim|required');
		$this->form_validation->set_rules('bulksmssenderid', 'BulkSMS Nigeria Sender ID','trim|required');
		$this->form_validation->set_rules('nsmsuser', 'Nigeria Bulksms User','trim|required');
		$this->form_validation->set_rules('nsmspass', 'Nigeria BulkSMS Pass','trim|required');
		$this->form_validation->set_rules('nsmssendid', 'Nigeria Bulksms Sender ID','trim|required');

		$this->form_validation->set_rules('mail_host', 'SMTP Host','trim|required');
		$this->form_validation->set_rules('mail_username', 'SMTP Username','trim|required');
		$this->form_validation->set_rules('mail_pass', 'SMTP Password','trim|required');
		$this->form_validation->set_rules('mail_port', 'SMTP Port','trim|required');

		$this->form_validation->set_rules('android_ver', 'Android App Version','trim|required');
		$this->form_validation->set_rules('ios_ver', 'iOS App Version','trim|required');

		$this->form_validation->set_rules('android_app_link', 'Android App Link','trim|required');
		$this->form_validation->set_rules('ios_app_link', 'iOS App Link','trim|required');

		if ($this->form_validation->run() == FALSE)
		{
			$data['_title']	= 'Settings';
			$this->load->theme('setting/index',$data);
		}
		else
		{ 
			$data = [
				'name'						=> $this->input->post('company'),
				'fserverkey'				=> $this->input->post('fserverkey'),
				'flutterapi'				=> $this->input->post('flutterapi'),
				'flutter_public'			=> $this->input->post('flutter_public'),
				'flutter_enc_key'			=> $this->input->post('flutter_enc_key'),
				'com_ussd'					=> $this->input->post('com_ussd'),
				'bulksmskey'				=> $this->input->post('bulksmskey'),
				'bulksmssenderid'			=> $this->input->post('bulksmssenderid'),
				'nsmsuser'					=> $this->input->post('nsmsuser'),
				'nsmspass'					=> $this->input->post('nsmspass'),
				'nsmssendid'				=> $this->input->post('nsmssendid'),
				'mail_host'					=> $this->input->post('mail_host'),
				'mail_username'				=> $this->input->post('mail_username'),
				'mail_pass'					=> $this->input->post('mail_pass'),
				'mail_port'					=> $this->input->post('mail_port'),
				'android_ver'				=> $this->input->post('android_ver'),
				'ios_ver'					=> $this->input->post('ios_ver'),
				'android_app_link'			=> $this->input->post('android_app_link'),
				'ios_app_link'				=> $this->input->post('ios_app_link')
			];
			$this->db->where('id','1');
			$this->db->update('setting',$data);
			
			$this->session->set_flashdata('msg', 'Settings Saved');
	        redirect(base_url('setting'));
		}
	}
}
?>