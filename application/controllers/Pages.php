<?php
class Pages extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->auth->check_session();
		$this->load->library('stripelib');
		$this->rights->redirect([4]);
	}

	public function index($value='')
	{
		// $stpCustomer = $this->stripelib->assignCard(
		// 	'cus_J9gdy2CZ0zO8mu',
		// 	'tok_1IXOGkGIryAQwZbS44otrByk'
		// );
		$stpCustomer = $this->stripelib->chargeClient(
			'100.00',
			'cus_J9gdy2CZ0zO8mu',
			'card_1IXOdSGIryAQwZbSGJlKgrZc'
		);		

		echo "<pre>";
		print_r($stpCustomer->source->brand);
		print_r($stpCustomer->source->last4);
		echo $this->stripelib->api_error;		
	}

	public function page($id = false)
	{
		if ($id) {
			$page = $this->general_model->get_page($id);
			if($page){
				$data['_title']		= "Page - ".$page['name'];	
				$data['page']		= $page;
				$this->load->theme('cms/page',$data);
			}else{
				redirect(base_url('error404'));	
			}
		}else{
			redirect(base_url('error404'));
		}
	}

	public function save()
	{
		$this->db->where('id',$this->input->post('id'))->update('pages',['content' => $this->input->post('content')]);
		$this->session->set_flashdata('msg', 'Page Saved');
		redirect(base_url('pages/page/').$this->input->post('id'));
	}
}