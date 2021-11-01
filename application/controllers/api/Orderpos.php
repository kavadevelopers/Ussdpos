<?php
class Orderpos extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function cancelorder()
	{
		if($this->input->post('order')){

			$this->db->where('id',$this->input->post('order'))->update('orders',['status' => "8",'note' => "Cancelled by agent"]);
			$orderId = $this->input->post('order');
			$template = $this->load->view('mail/orders/order_placed',['id' => $orderId],true);
			@$this->general_model->send_mail($this->agent_model->getSomeInfo($order->user)->email,'Order Status Changed',$template);
			@$this->general_model->send_mail(get_setting()['admin_noti_email'],'Order Cancelled by agent',$template);

			retJson(['_return' => true]);
						
		}else{
			retJson(['_return' => false,'msg' => '`order` are Required']);
		}
	}

	public function getorders()
	{
		if($this->input->post('user')){
			$this->db->order_by('id','desc');
			$this->db->where('user',$this->input->post('user'));	
			$orders = $this->db->get('orders');
			$list = $orders->result_object();

			foreach ($list as $key => $value) {
				$list[$key]->poption			= posPurchaseOption($value->poption);
				$list[$key]->product 			= $this->general_model->getProduct($value->product);
				$list[$key]->paymenttype		= strtoupper($value->paymenttype);
				$list[$key]->deliverytype		= deliveryType($value->deliverytype);
				$list[$key]->status				= getStatusString($value->status);
				$list[$key]->statusint			= $value->status;
				$list[$key]->cat				= getPretyDateTime($value->cat);
			}

			retJson(['_return' => true,'count' => $orders->num_rows(),'orders' => $list]);
		}else{
			retJson(['_return' => false,'msg' => '`user` are Required']);
		}
	}

	public function order()
	{
		if($this->input->post('poption') && $this->input->post('user') && $this->input->post('product') && $this->input->post('qty') && $this->input->post('price') && $this->input->post('subtotal') && $this->input->post('delivery') && $this->input->post('total') && $this->input->post('paymenttype') && $this->input->post('deliverytype') && $this->input->post('state')){
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
				'ordid'				=> generateOrderId(),
				'poption'			=> $this->input->post('poption'),
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
				'note'				=> '',
				'cat'				=> _nowDateTime()
			];
			$this->db->insert('orders',$data);
			$orderId = $this->db->insert_id();
			$fullAddress = $terminal.' '.$address.' '.$buspark.' '.$this->input->post('state');

			if ($this->input->post('paymenttype') == "wallet") {
				@$this->transaction_model->posOrder($this->input->post('user'),$this->input->post('total'),$orderId);
			}

			//Admin Email
			$template = $this->load->view('mail/admin/new_pos_order',['id' => $orderId],true);
			@$this->general_model->send_mail(get_setting()['admin_noti_email'],'POS Order received',$template);

			//Order Placed Email
			$template = $this->load->view('mail/orders/order_placed',['id' => $orderId],true);
			@$this->general_model->send_mail($this->agent_model->getSomeInfo($this->input->post('user'))->email,'Order Placed',$template);

			retJson(['_return' => true,'msg' => 'Order Placed','address' => $fullAddress]);
		}else{
			retJson(['_return' => false,'msg' => '`poption`,`user`,`product`,`qty`,`price`,`subtotal`,`delivery`,`total`,`paymenttype`,`deliverytype`,`state` are Required, `terminal`,`address`,`buspark` are Optional']);
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