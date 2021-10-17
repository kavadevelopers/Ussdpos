<?php
class Orderpos extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function order()
	{
		if($this->input->post('user') && $this->input->post('product') && $this->input->post('qty') && $this->input->post('price') && $this->input->post('subtotal') && $this->input->post('delivery') && $this->input->post('total') && $this->input->post('paymenttype') && $this->input->post('deliverytype') && $this->input->post('state')){
			$terminal = ""; $address = ""; $buspark = "";
			if ($this->input->post('terminal')) {
				$terminal = $this->input->post('terminal');
			}
			if ($this->input->post('address')) {
				$address = $this->input->post('address');
			}
			if ($this->input->post('buspark')) {
				$buspark = $this->input->post('buspark');
			}

			$data = [
				'user'				=> $this->input->post('user'),
				'product'			=> $this->input->post('product'),
				'qty'				=> $this->input->post('qty'),
				'price'				=> $this->input->post('price'),
				'subtotal'			=> $this->input->post('subtotal'),
				'delivery'			=> $this->input->post('delivery'),
				'total'				=> $this->input->post('total'),
				'paymenttype'		=> $this->input->post('paymenttype'),
				'deliverytype'		=> $this->input->post('deliverytype'),
				'state'				=> $this->input->post('state'),
				'terminal'			=> $terminal,
				'address'			=> $address,
				'buspark'			=> $buspark,
				'status'			=> '0',
				'cat'				=> _nowDateTime()
			];
			$this->db->insert('orders',$data);

			$fullAddress = $terminal.' '.$address.' '.$buspark.' '.$this->input->post('state');

			retJson(['_return' => true,'msg' => 'Order Placed','address' => $fullAddress]);
		}else{
			retJson(['_return' => false,'msg' => '`user`,`product`,`qty`,`price`,`subtotal`,`delivery`,`total`,`paymenttype`,`deliverytype`,`state` are Required, `terminal`,`address`,`buspark` are Optional']);
		}	
	}

	public function getdeliverycharges()
	{
		if($this->input->post('user')){
			$delivery = $this->db->get_where('order_delivery_charges',['id' => '1'])->row_object();
			retJson(['_return' => true,'user' => $this->agent_model->get($this->input->post('user')),'balance' => $this->dashboard_model->getAgentBalance($this->input->post('user')),'delivery' => $delivery]);
		}else{
			retJson(['_return' => false,'msg' => '`user` are Required']);
		}
	}

	public function getproducts()
	{
		if ($this->input->post('category') && $this->input->post('type')) {
			if ($this->input->post('type') == "1") {
				$this->db->where('lprice !=','0.00');
				$this->db->where('leasemonth !=','0');
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
				$list[$key]->pleasemonth 	=	$value->leasemonth;
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