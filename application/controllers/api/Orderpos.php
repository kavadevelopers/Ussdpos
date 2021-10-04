<?php
class Orderpos extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getproducts()
	{
		if ($this->input->post('category')) {
			$query = $this->db->get_where('products',['df' => '']);
			$list = $query->result_object();
			foreach ($list as $key => $value) {
				$list[$key]->image =	$this->general_model->getProductThumb($value->id);
			}
			retJson(['_return' => true,'msg' => '','prodcount' => $query->num_rows(),'prodlist' => $list]);
		}else{
			retJson(['_return' => false,'msg' => '`category` are Required']);
		}
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