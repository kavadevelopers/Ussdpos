<?php
class Master extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}


	public function getbanks()
	{
		if ($this->input->post('type')) {
			
			$this->db->where('type',$this->input->post('type'));
			$list = $this->db->get('master_banks')->result_array();

			retJson(['_return' => true,'list' => $list]);

		}else{
			retJson(['_return' => false,'msg' => '`type` are Required']);
		}
	}
}