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
		$this->form_validation->set_rules('support_email', 'Support Email','trim|required');
		$this->form_validation->set_rules('support_mobile', 'Support Mobile','trim|required');
		$this->form_validation->set_rules('customer_support_phone', 'Customer Support Phone','trim|required');
		$this->form_validation->set_rules('mail_host', 'SMTP Host','trim|required');
		$this->form_validation->set_rules('mail_username', 'SMTP Username','trim|required');
		$this->form_validation->set_rules('mail_pass', 'SMTP Password','trim|required');
		$this->form_validation->set_rules('mail_port', 'SMTP Port','trim|required');

		$this->form_validation->set_rules('shop_rule', 'Shop Rules','trim|required');

		$this->form_validation->set_rules('stripe_sk', 'Stripe Secret key','trim|required');
		$this->form_validation->set_rules('stripe_pk', 'Stripe Publishable key','trim|required');

		$this->form_validation->set_rules('android_ver', 'Android App Version','trim|required');
		$this->form_validation->set_rules('ios_ver', 'iOS App Version','trim|required');

		$this->form_validation->set_rules('prod_tax', 'Product Tax','trim|required');
		$this->form_validation->set_rules('serv_tax', 'Service Tax','trim|required');

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
				'support_email'				=> $this->input->post('support_email'),
				'support_mobile'			=> $this->input->post('support_mobile'),
				'customer_support_phone'			=> $this->input->post('customer_support_phone'),
				'shop_rule'					=> $this->input->post('shop_rule'),
				'mail_host'					=> $this->input->post('mail_host'),
				'mail_username'				=> $this->input->post('mail_username'),
				'mail_pass'					=> $this->input->post('mail_pass'),
				'mail_port'					=> $this->input->post('mail_port'),
				'android_ver'				=> $this->input->post('android_ver'),
				'ios_ver'					=> $this->input->post('ios_ver'),
				'stripe_sk'					=> $this->input->post('stripe_sk'),
				'stripe_pk'					=> $this->input->post('stripe_pk'),
				'prod_tax'					=> $this->input->post('prod_tax'),
				'serv_tax'					=> $this->input->post('serv_tax'),
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