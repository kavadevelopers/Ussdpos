<?php
class Orderpos extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getproducts()
	{
		if ($this->input->post('category') && $this->input->post('type')) {
			if ($this->input->post('type') == "1") {
				$this->db->where('lprice !=','0.00');
			}
			if ($this->input->post('type') == "2") {
				$this->db->where('leasefee !=','0.00');
			}
			if ($this->input->post('type') == "3") {
				$this->db->where('price !=','0.00');
			}
			$query = $this->db->get_where('products',['df' => '','category' => $this->input->post('category'),'']);
			$list = $query->result_object();
			foreach ($list as $key => $value) {
				$list[$key]->image 			=	$this->general_model->getProductThumb($value->id);
				$list[$key]->chargeinfo 	=	$this->general_model->getProductInfo($value->id);
				$list[$key]->pprice 		=	ptPretyAmount($value->price);
				$list[$key]->pleasefee 		=	ptPretyAmount($value->leasefee);
				$list[$key]->pleasemonth 	=	ptPretyAmount($value->leasemonth);
				$list[$key]->permonth 		=	ptPretyAmount($value->lprice / $value->leasemonth);
			}
			retJson(['_return' => true,'msg' => '','prodcount' => $query->num_rows(),'prodlist' => $list]);
		}else{
			retJson(['_return' => false,'msg' => '`category`,`type`(1{Lease Purchase},2{Lease Rent},3{Outright Purchase}) are Required']);
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