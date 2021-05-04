<?php
class Shop_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getCart($user,$promoCodea = false)
	{
		$list = $this->db->get_where('booking_products',['booking' => '','user' => $user])->result_array();
		$shops = getDistinctShopFromCart($user);
		if ($promoCodea) {
			$promoCode = getPromoAmount($promoCodea,$user,$shops);
		}else{
			$promoCode = false;
		}
		$disconutAmount = 0;
		if ($promoCode) {
			$this->db->select_sum('subtotal');
			$this->db->where('booking','');
			$this->db->where('user',$user);
			$this->db->where('shop',$promoCode['shop']);
			$this->db->from('booking_products');
			$disconutAmount = $this->db->get()->row()->subtotal;
		}
		foreach ($list as $key => $value) {
			$list[$key]['product_ob'] = $this->shop_model->getProduct($value['product'],$user);
			$disCount = $this->db->get_where('promo_prods',['service' => $value['service'],'prods' => $value['qty']])->row_array();
			if($disCount && $value['type'] == 'product'){
				$subTotal = $list[$key]['product_ob']['price'] * $value['qty'];
				$list[$key]['product_discount'] = $subTotal * $disCount['percentage'] / 100;
			}else{
				$list[$key]['product_discount'] = '0.00';
			}

			if($promoCode && $promoCode['shop'] == $value['shop']){
				$list[$key]['discount'] = getDiscountAfter($promoCode['amount'],$value['subtotal'],$disconutAmount);
			}else{
				$list[$key]['discount'] = '0.00';
			}	

			if($value['type'] == "product"){
				$list[$key]['tax'] = getTax($value['subtotal'],get_setting()['prod_tax']);
			}else{
				$list[$key]['tax'] = getTax($value['subtotal'],get_setting()['serv_tax']);
			}


			if($value['type'] == "product"){
				$list[$key]['shipping_charge'] = $list[$key]['product_ob']['shipping_charge'];
			}else{
				$list[$key]['shipping_charge'] = '0.00';
			}
		}
		$response = [
			'cart' => $list
		];
		if($promoCodea){
			$response['promo']['added'] 		= "yes";
			if ($promoCode) {
				$response['promo']['_return'] 	= true;
				$response['promo']['data']		= $promoCode;
			}else{
				$response['promo']['_return'] 	= false;
				$response['promo']['msg'] 		= "Promo Code is not valid";
			}
		}else{
			$response['promo']['added'] 		= "no";
		}
		return $response;
	}

	public function getShop($id)
	{
		$this->db->where('id',$id);
		$data = $this->db->get('shop')->row_array();
		$images = [];
		foreach ($this->db->get_where('shop_images',['shop' => $data['id']])->result_array() as $Ikey => $Ivalue) {
			array_push($images,['image' => base_url('uploads/shop/').$Ivalue['image'],'id' => $Ivalue['id']]);
		}
		$data['images'] 		= $images;
		$data['timing']			= $this->db->get_where('shop_timing',['shop' => $data['id']])->row_array();
		$data['rules']			= $this->db->get_where('shop_rules',['shop' => $data['id']])->result_array();
		$data['review_count']	= $this->db->get_where('service_review',['shop_id' => $data['id']])->num_rows();
		return $data;
	}

	public function getProduct($id,$user = false)
	{
		$customerSingle = $user;
		$this->db->where('id',$id);
		$data = $this->db->get('shop_products')->row_array();
		$images = [];
		foreach ($this->db->get_where('shop_product_image',['product' => $data['id']])->result_array() as $Ikey => $Ivalue) {
			array_push($images,['image' => base_url('uploads/product/').$Ivalue['image'],'id' => $Ivalue['id']]);
		}
		$data['images'] = $images;
		if ($user) {
			$favGet = $this->db->get_where('others_favourite_products',['product' => $id,'user' => $user])->row_array();
			if ($favGet) {
				$data['isfavourite'] = 1;
			}else{
				$data['isfavourite'] = 0;
			}
		}else{
			$data['isfavourite'] = 0;
		}
		if($data['type'] == 'service'){
			$data['tax']			= get_setting()['serv_tax'];
		}else{
			$data['tax']			= get_setting()['prod_tax'];
		}
		$data['shop']			= $this->getShop($data['shop']);
		$data['fav_count']		= $this->db->get_where('others_favourite_products',['product' => $id])->num_rows();
		if($data['type'] == "product"){
			$data['brand_ob']	= $this->db->get_where('master_brand',['id' => $data['brand']])->row_array();	
			$data['size_ob']	= $this->db->get_where('master_size',['id' => $data['size']])->row_array();	
		}
		$data['category_ob']	= $this->general_model->getCategory($data['category']);
		$data['service_pro']	= $this->service_model->getServiceData($data['user']);
		$users = [];
		$user = $this->service_model->getServiceData($data['user']);
		array_push($users, 
			[
				'id'	=> $user['id'],
				'name' 	=> $user['firstname'].' '.$user['lastname'],
				'price' => $data['price'],
				'type' 	=> 'Founder/Owner',
				'image' => $user['profile_pic'],
				'open_close' => $this->db->get_where('service_timing',['service' => $user['id']])->row_array()
			]
		);

		$userList = $this->db->get_where('service_provider',['shop' => $data['shop']['id'],'df' => '','block' => ''])->result_array();
		foreach ($userList as $uKey => $uValue) {
			$user = $this->service_model->getServiceData($uValue['id']);
			array_push($users, 
				[
					'id'	=> $user['id'],
					'name' 	=> $user['firstname'].' '.$user['lastname'],
					'price' => $data['price'],
					'type' 	=> ucfirst($user['utype']),
					'image' => $user['profile_pic'],
					'open_close' => $this->db->get_where('service_timing',['service' => $user['id']])->row_array()
				]
			);			
		}

		$data['providers'] = $users;


		if ($user) {
			$cart = $this->db->get_where('booking_products',['user' => $customerSingle,'product' => $id,'booking' => ''])->row_array();
			$data['cart'] = $cart;
		}else{
			$data['cart'] = null;
		}

		return $data;
	}
}