<?php
class Orderpos extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}



	public function getcategory()
	{
		$this->db->where('df','');
		$get = $this->db->get('products_cate');


		$list = $get->result_object();
		foreach ($list as $key => $value) {
			$list[$key]->image 		= $this->general_model->getCategoryThumb($value->id);
		}
		retJson(['_return' => true,'catcount' => $get->num_rows(),'catlist' => $list]);
	}
}