<?php
class General extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getpage()
	{
		$settings = [
			'_return'			=> true,
			'content'			=> $this->db->get_where('cms_pages',['id' => $this->input->post('page')])->row_object()->descr
		];

		retJson($settings);	
	}

	public function getsettings()
	{
		$settings = [
			'terms'		=> $this->db->get_where('cms_pages',['id' => '1'])->row_object()->descr
		];

		retJson($settings);
	}

}