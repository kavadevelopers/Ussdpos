<?php
class General extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getbanks()
	{
		if ($this->input->post('type')) {
			
			$this->db->where('type',$this->input->post('type'));
			$query = $this->db->get('master_banks');


			$list = $query->result_object();
			foreach ($list as $key => $value) {
				$value->image = $this->general_model->getBankThumb($value->id);
			}

			retJson(['_return' => true,'count' => $query->num_rows(),'list' => $list]);

		}else{
			retJson(['_return' => false,'msg' => '`type` are Required']);
		}
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