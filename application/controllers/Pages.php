<?php
class Pages extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->auth->check_session();
		$this->rights->redirect([2]);
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
		$this->db->where('id',$this->input->post('id'))->update('cms_pages',['descr' => $this->input->post('content')]);
		$this->session->set_flashdata('msg', 'Page Saved');
		redirect(base_url('pages/page/').$this->input->post('id'));
	}
}