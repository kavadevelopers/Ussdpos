<?php
class Shop extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_service_single()
	{
		if($this->input->post('product')){	
			$data = $this->shop_model->getProduct($this->input->post('product'));
			$data['review_count']	= $this->db->get_where('service_review',['product' => $this->input->post('product')])->num_rows();
			$reviews = $this->db->get_where('service_review',['product' => $this->input->post('product')])->result_array();
			$reviewsList = [];
			foreach ($reviews as $key => $value) {
				$value['customer_ob']	= $this->customer_model->getCustomerData($value['customer']);
				array_push($reviewsList, $value);
			}
			$data['reviews_list'] = $reviewsList;


			$services = $this->db->get_where('shop_products',['type' => 'service','shop' => $data['shop']['id'],'id !=' => $this->input->post('product')])->result_array();
			foreach ($services as $key => $value) {
				$services[$key] = $this->shop_model->getProduct($value['id']);
			}

			$data['service_list'] = $services;			

			retJson(['_return' => true,'data' => $data]);
		}else{
			retJson(['_return' => false,'msg' => '`product` is Required']);
		}
	}

	public function report_shop()
	{
		if ($this->input->post('shop') && $this->input->post('title') && $this->input->post('comment') && $this->input->post('customer')) {
			$data = [
				'shop'		=> $this->input->post('shop'),
				'title'		=> $this->input->post('title'),
				'comment'	=> $this->input->post('comment'),
				'customer'	=> $this->input->post('customer'),
				'cat'		=> _nowDateTime()
			];
			$this->db->insert('shop_report',$data);
			retJson(['_return' => true,'msg' => 'Shop Reported']);
		}else{
			retJson(['_return' => false,'msg' => '`shop`,`title`,`comment`,`customer` are Required']);
		}	
	}

	public function modify_rule()
	{
		if ($this->input->post('shop') && $this->input->post('type')) {
			if ($this->input->post('type') == "edit") {
				
				if($this->input->post('rule_id') && $this->input->post('rule')){
					$this->db->where('id',$this->input->post('rule_id'))->update('shop_rules',['rule' => $this->input->post('rule')]);
					retJson(['_return' => true,'msg' => 'Rule Updated']);		
				}else{
					retJson(['_return' => false,'msg' => '`rule_id`,`rule` are Required']);		
				}				

			}else if($this->input->post('type') == "delete"){
				if($this->input->post('rule_id')){
					$this->db->where('id',$this->input->post('rule_id'))->delete('shop_rules');
					retJson(['_return' => true,'msg' => 'Rule Deleted']);		
				}else{
					retJson(['_return' => false,'msg' => '`rule_id` are Required']);		
				}
			}else{
				retJson(['_return' => false,'msg' => 'Not a valid type']);	
			}
		}else{
			retJson(['_return' => false,'msg' => '`shop`,`type` are Required']);
		}
	}

	public function add_rule()
	{
		if($this->input->post('shop') && $this->input->post('rule')){

			$data = [
				'shop'	=> $this->input->post('shop'),
				'rule'	=> $this->input->post('rule')
			];
			$this->db->insert('shop_rules',$data);
			retJson(['_return' => true,'msg' => 'Rule Created']);

		}else{
			retJson(['_return' => false,'msg' => '`shop`,`rule` are Required']);
		}
	}

	public function modify_timing()
	{
		if($this->input->post('shop')){
			$shop = $this->db->get_where('shop_timing',['shop' => $this->input->post('shop')])->row_array();
			$data = [];
			if($this->input->post('monday_from')){
				$data['monday_from']	= $this->input->post('monday_from');
			}else{
				$data['monday_from'] 	= NULL;
			}
			if($this->input->post('monday_to')){
				$data['monday_to']	= $this->input->post('monday_to');
			}else{
				$data['monday_to'] 	= NULL;
			}
			if($this->input->post('tuesday_from')){
				$data['tuesday_from']	= $this->input->post('tuesday_from');
			}else{
				$data['tuesday_from'] 	= NULL;
			}
			if($this->input->post('tuesday_to')){
				$data['tuesday_to']	= $this->input->post('tuesday_to');
			}else{
				$data['tuesday_to'] 	= NULL;
			}
			if($this->input->post('wednesday_from')){
				$data['wednesday_from']	= $this->input->post('wednesday_from');
			}else{
				$data['wednesday_from'] 	= NULL;
			}
			if($this->input->post('wednesday_to')){
				$data['wednesday_to']	= $this->input->post('wednesday_to');
			}else{
				$data['wednesday_to'] 	= NULL;
			}
			if($this->input->post('thursday_from')){
				$data['thursday_from']	= $this->input->post('thursday_from');
			}else{
				$data['thursday_from'] 	= NULL;
			}
			if($this->input->post('thursday_to')){
				$data['thursday_to']	= $this->input->post('thursday_to');
			}else{
				$data['thursday_to'] 	= NULL;
			}
			if($this->input->post('friday_from')){
				$data['friday_from']	= $this->input->post('friday_from');
			}else{
				$data['friday_from'] 	= NULL;
			}
			if($this->input->post('friday_to')){
				$data['friday_to']	= $this->input->post('friday_to');
			}else{
				$data['friday_to'] 	= NULL;
			}
			if($this->input->post('saturday_from')){
				$data['saturday_from']	= $this->input->post('saturday_from');
			}else{
				$data['saturday_from'] 	= NULL;
			}
			if($this->input->post('saturday_to')){
				$data['saturday_to']	= $this->input->post('saturday_to');
			}else{
				$data['saturday_to'] 	= NULL;
			}
			if($this->input->post('sunday_from')){
				$data['sunday_from']	= $this->input->post('sunday_from');
			}else{
				$data['sunday_from'] 	= NULL;
			}
			if($this->input->post('sunday_to')){
				$data['sunday_to']	= $this->input->post('sunday_to');
			}else{
				$data['sunday_to'] 	= NULL;
			}

			if ($shop) {
				$this->db->where('shop',$this->input->post('shop'))->update('shop_timing',$data);
			}else{
				$data['shop']	= $this->input->post('shop');
				$this->db->insert('shop_timing',$data);
			}

			retJson(['_return' => true,'msg' => 'Timing Updated']);
		}else{
			retJson(['_return' => false,'msg' => '`shop` is Required,Optional parameters are `monday_from`,`monday_to`,`tuesday_from`,`tuesday_to`,`wednesday_from`,`wednesday_to`,`thursday_from`,`thursday_to`,`friday_from`,`friday_to`,`saturday_from`,`saturday_to`,`sunday_from`,`sunday_to`']);
		}
	}

	public function filteritems(){	
		if($this->input->post('type') && $this->input->post('sort')){
			if($this->input->post('start') !== null && $this->input->post('limit')){
				$this->db->limit($this->input->post('limit'), $this->input->post('start'));
			}
			
			//Sorting
			if($this->input->post('sort') == "priceasc"){
				$this->db->order_by('price','asc');
			}else if($this->input->post('sort') == "pricedesc"){
				$this->db->order_by('price','desc');
			}

			// Type product or service
			if($this->input->post('type') == "service"){
				$this->db->where('type',$this->input->post('type'));
			}else if($this->input->post('type') == "product"){
				$this->db->where('type',$this->input->post('type'));
			}

			//Like Title
			if($this->input->post('q')){
				$this->db->like('title', $this->input->post('q'));
			}

			//filter by services/category
			if($this->input->post('categories')){
				$this->db->where_in('category', explode(',', $this->input->post('categories')));
			}			

			if($this->input->post('minprice')){
				$this->db->where('price >=',$this->input->post('minprice'));
			}

			if($this->input->post('maxprice')){
				$this->db->where('price <=',$this->input->post('maxprice'));
			}

			//bathroom filter
			if($this->input->post('bathroom')){
				$this->db->where('bathroom',$this->input->post('bathroom'));
			}

			//entrance filter
			if($this->input->post('entrance')){
				$this->db->where('entrance',$this->input->post('entrance'));
			}

			//getting_around filter
			if($this->input->post('getting_around')){
				$this->db->where('getting_around',$this->input->post('getting_around'));
			}

			//elevator filter
			if($this->input->post('elevator')){
				$this->db->where('elevator',$this->input->post('elevator'));
			}

			//parking filter
			if($this->input->post('parking')){
				$this->db->where('parking',$this->input->post('parking'));
			}

			$userClient = false;
			if($this->input->post('user')){
				$userClient = $this->input->post('user');
			}
			$this->db->where('df','');
			$this->db->where('block','no');
			$list = $this->db->get('shop_products')->result_array();
			foreach ($list as $key => $value) {
				$filterError = 0;
				if($this->input->post('shop_rating')){
					$shop = $this->db->get_where('shop',['id' => $value['shop']])->row_array();
					if($shop['rating'] < $this->input->post('shop_rating')){
						$filterError++;
					}
				}


				if($filterError == 0){
					$prod = $this->shop_model->getProduct($value['id'],$userClient);
					$list[$key] = $prod;
					if($this->input->post('user')){
						$cart = $this->db->get_where('booking_products',['user' => $this->input->post('user'),'product' => $value['id'],'booking' => ''])->row_array();
						$list[$key]['cart'] = $cart;
					}
				}
			}

			retJson(['_return' => true,'list' => $list]);
		}else{
			retJson(['_return' => false,'msg' => '`type`(service,product,both),`sort`(toprated,recommended,closest,priceasc,pricedesc) are Required,Optional parameters are `q`(query parameter type here text),`categories`(add comma saparated services ids),`minprice`,`maxprice`,`start`,`limit`,`user`,`shop_rating`,`bathroom`,`entrance`,`getting_around`,`elevator`,`parking`']);
		}
	}

	public function get_prod_serv_single()
	{
		if($this->input->post('product')){	
			$data = $this->shop_model->getProduct($this->input->post('product'));
			retJson(['_return' => true,'data' => $data]);
		}else{
			retJson(['_return' => false,'msg' => '`product` is Required']);
		}
	}

	public function get_prod_serv()
	{
		if($this->input->post('shop')){	
			if($this->input->post('start') !== null && $this->input->post('limit')){
				$this->db->limit($this->input->post('limit'), $this->input->post('start'));
			}
			if($this->input->post('type')){
				$this->db->where('type',$this->input->post('type'));	
			}
			$this->db->where('shop',$this->input->post('shop'));
			$this->db->where('df','');
			$list = $this->db->get('shop_products')->result_array();

			foreach ($list as $key => $value) {
				$prod = $this->shop_model->getProduct($value['id']);
				$list[$key] = $prod;
			}

			if($this->input->post('type')){
				$this->db->where('type',$this->input->post('type'));	
			}
			$this->db->where('shop',$this->input->post('shop'));
			$this->db->where('df','');
			$total = $this->db->get('shop_products')->num_rows();

			retJson(['_return' => true,'total' => $total,'list' => $list]);
		}else{
			retJson(['_return' => false,'msg' => '`shop` is Required,`type`(service,product),`start`,`limit` are optional']);
		}
	}

	public function block_prod_service()
	{
		if($this->input->post('product') && $this->input->post('block')){
			foreach (explode(",", $this->input->post('product')) as $key => $value) {
				$this->db->where('id',$value)->update('shop_products',['block' => $this->input->post('block')]);
			}
			retJson(['_return' => true,'msg' => 'Product Updated']);
		}else{
			retJson(['_return' => false,'msg' => '`product`(add comma saparated values),`block`(yes,no) are Required']);
		}	
	}	

	public function delete_prod_service()
	{
		if($this->input->post('product')){
			$this->db->where('id',$this->input->post('product'))->update('shop_products',['df' => 'yes']);
			retJson(['_return' => true,'msg' => 'Product Deleted']);
		}else{
			retJson(['_return' => false,'msg' => '`product` are Required']);
		}	
	}

	public function edit_prod_service()
	{
		if($this->input->post('user') && $this->input->post('shop') && $this->input->post('type') && $this->input->post('product')){	
			if($this->input->post('type') == "service"){
				if($this->input->post('title') && $this->input->post('desc') && $this->input->post('tag') && $this->input->post('duration') && $this->input->post('price') && $this->input->post('category')){
					$data = [
						'shop'		=> $this->input->post('shop'),
						'user'		=> $this->input->post('user'),
						'type'		=> 'service',
						'category'	=> $this->input->post('category'),
						'title'		=> $this->input->post('title'),
						'descr'		=> $this->input->post('desc'),
						'tag'		=> $this->input->post('tag'),
						'duration'	=> $this->input->post('duration'),
						'price'		=> $this->input->post('price'),
						'brand'		=> NULL,
						'size'		=> NULL
					];
					$this->db->where('id',$this->input->post('product'))->update('shop_products',$data);
					$productId = $this->input->post('product');
					if( count($this->input->post('images')) > 0){
						foreach ($this->input->post('images') as $ikey => $ivalue) {
							$img = $ivalue;
							$img = str_replace('data:image/png;base64,', '', $img);
							$img = str_replace(' ', '+', $img);
							$data = base64_decode($img);
							$file = microtime(true).'.png';
							file_put_contents('./uploads/product/'.$file, $data);		
							$img = [
								'image'		=> $file,
								'product'	=> $productId,
								'user'		=> $this->input->post('user')
							];
							$this->db->insert('shop_product_image',$img);
						}
					}
					foreach (explode(',', $this->input->post('delete_images')) as $key => $value) {
						$this->db->where('id',$value)->delete('shop_product_image');
					}
					retJson(['_return' => true,'msg' => 'Service Updated']);
				}else{
					retJson(['_return' => false,'msg' => '`title`,`desc`,`tag`(if multiple add comma saperated),`duration`,`price`,`category` are Required,Optional parameters are`images[]`,`delete_images` ']);	
				}
			}else if($this->input->post('type') == "product"){
				if($this->input->post('title') && $this->input->post('desc') && $this->input->post('tag') && $this->input->post('price') && $this->input->post('category') && $this->input->post('brand') && $this->input->post('size')){

					$shipping_charge = 	0.00;
					if ($this->input->post('shipping_charge')) {
						$shipping_charge = 	$this->input->post('shipping_charge');
					}

					$data = [
						'shop'		=> $this->input->post('shop'),
						'user'		=> $this->input->post('user'),
						'type'		=> 'product',
						'category'	=> $this->input->post('category'),
						'title'		=> $this->input->post('title'),
						'descr'		=> $this->input->post('desc'),
						'tag'		=> $this->input->post('tag'),
						'duration'	=> NULL,
						'price'		=> $this->input->post('price'),
						'brand'		=> $this->input->post('brand'),
						'size'		=> $this->input->post('size'),
						'shipping_charge'		=> $shipping_charge
					];
					$this->db->where('id',$this->input->post('product'))->update('shop_products',$data);
					$productId = $this->input->post('product');
					if( count($this->input->post('images')) > 0){
						foreach ($this->input->post('images') as $ikey => $ivalue) {
							$img = $ivalue;
							$img = str_replace('data:image/png;base64,', '', $img);
							$img = str_replace(' ', '+', $img);
							$data = base64_decode($img);
							$file = microtime(true).'.png';
							file_put_contents('./uploads/product/'.$file, $data);		
							$img = [
								'image'		=> $file,
								'product'	=> $productId,
								'user'		=> $this->input->post('user')
							];
							$this->db->insert('shop_product_image',$img);
						}
					}
					foreach (explode(',', $this->input->post('delete_images')) as $key => $value) {
						$this->db->where('id',$value)->delete('shop_product_image');
					}
					retJson(['_return' => true,'msg' => 'Product Updated']);

				}else{
					retJson(['_return' => false,'msg' => '`title`,`desc`,`tag`(if multiple add comma saperated),`price`,`category`,`brand`,`size` are Required, `shipping_charge`,`images[]`,`delete_images` are optional']);		
				}
			}
			else{
				retJson(['_return' => false,'msg' => '`type` not found']);
			}
		}else{
			retJson(['_return' => false,'msg' => '`user`,`type`(product,service),`product` and `shop` are Required']);
		}	
	}

	public function create_prod_serv()
	{
		if($this->input->post('user') && $this->input->post('shop') && $this->input->post('type')){	
			if($this->input->post('type') == "service"){
				if($this->input->post('title') && $this->input->post('desc') && $this->input->post('tag') && $this->input->post('duration') && $this->input->post('price') && $this->input->post('images') && $this->input->post('category')){
					$data = [
						'shop'		=> $this->input->post('shop'),
						'user'		=> $this->input->post('user'),
						'type'		=> 'service',
						'category'	=> $this->input->post('category'),
						'title'		=> $this->input->post('title'),
						'descr'		=> $this->input->post('desc'),
						'tag'		=> $this->input->post('tag'),
						'duration'	=> $this->input->post('duration'),
						'price'		=> $this->input->post('price'),
						'brand'		=> NULL,
						'size'		=> NULL,
						'cat'		=> _nowDateTime()
					];
					$this->db->insert('shop_products',$data);
					$productId = $this->db->insert_id();

					foreach ($this->input->post('images') as $ikey => $ivalue) {
						$img = $ivalue;
						$img = str_replace('data:image/png;base64,', '', $img);
						$img = str_replace(' ', '+', $img);
						$data = base64_decode($img);
						$file = microtime(true).'.png';
						file_put_contents('./uploads/product/'.$file, $data);		
						$img = [
							'image'		=> $file,
							'product'	=> $productId,
							'user'		=> $this->input->post('user')
						];
						$this->db->insert('shop_product_image',$img);
					}
					retJson(['_return' => true,'msg' => 'Service Created']);
				}else{
					retJson(['_return' => false,'msg' => '`title`,`desc`,`tag`(if multiple add comma saperated),`duration`,`price`,`category` and `images` are Required']);		
				}
			}else if($this->input->post('type') == "product"){
				if($this->input->post('title') && $this->input->post('desc') && $this->input->post('tag') && $this->input->post('price') && $this->input->post('images') && $this->input->post('category') && $this->input->post('brand') && $this->input->post('size')){

					$shipping_charge = 	0.00;
					if ($this->input->post('shipping_charge')) {
						$shipping_charge = 	$this->input->post('shipping_charge');
					}

					$data = [
						'shop'		=> $this->input->post('shop'),
						'user'		=> $this->input->post('user'),
						'type'		=> 'product',
						'category'	=> $this->input->post('category'),
						'title'		=> $this->input->post('title'),
						'descr'		=> $this->input->post('desc'),
						'tag'		=> $this->input->post('tag'),
						'duration'	=> NULL,
						'price'		=> $this->input->post('price'),
						'brand'		=> $this->input->post('brand'),
						'size'		=> $this->input->post('size'),
						'shipping_charge'		=> $shipping_charge,
						'cat'					=> _nowDateTime()
					];
					$this->db->insert('shop_products',$data);
					$productId = $this->db->insert_id();

					foreach ($this->input->post('images') as $ikey => $ivalue) {
						$img = $ivalue;
						$img = str_replace('data:image/png;base64,', '', $img);
						$img = str_replace(' ', '+', $img);
						$data = base64_decode($img);
						$file = microtime(true).'.png';
						file_put_contents('./uploads/product/'.$file, $data);		
						$img = [
							'image'		=> $file,
							'product'	=> $productId,
							'user'		=> $this->input->post('user')
						];
						$this->db->insert('shop_product_image',$img);
					}
					retJson(['_return' => true,'msg' => 'Product Created']);

				}else{
					retJson(['_return' => false,'msg' => '`title`,`desc`,`tag`(if multiple add comma saperated),`price`,`category`,`brand`,`size` and `images` are Required, `shipping_charge` is optional']);		
				}
			}
			else{
				retJson(['_return' => false,'msg' => '`type` not found']);
			}
		}else{
			retJson(['_return' => false,'msg' => '`user`,`type`(product,service) and `shop` are Required']);
		}	
	}

	public function getshop()
	{
		if($this->input->post('shop')){	
			$shop = $this->shop_model->getShop($this->input->post('shop'));
			$providers = $this->db->get_where('service_provider',['shop' => $this->input->post('shop')])->result_array();
			$providersList = [];
			foreach ($providers as $key => $value) {
				array_push($providersList, $this->service_model->getServiceData($value['id']));
			}
			$shop['providers_list'] = $providersList;

			$reviews = $this->db->get_where('service_review',['shop_id' => $this->input->post('shop')])->result_array();
			$reviewsList = [];
			foreach ($reviews as $key => $value) {
				$value['customer_ob']	= $this->customer_model->getCustomerData($value['customer']);
				array_push($reviewsList, $value);
			}
			$shop['reviews_list'] = $reviewsList;

			$services = $this->db->get_where('shop_products',['shop' => $this->input->post('shop'),'type' => 'service'])->result_array();
			$serviceList = [];
			foreach ($services as $key => $value) {
				$this->db->where('id',$value['id']);
				$data = $this->db->get('shop_products')->row_array();
				$images = [];
				foreach ($this->db->get_where('shop_product_image',['product' => $value['id']])->result_array() as $Ikey => $Ivalue) {
					array_push($images,['image' => base_url('uploads/product/').$Ivalue['image'],'id' => $Ivalue['id']]);
				}
				$value['images'] = $images;
				array_push($serviceList, $value);
			}
			$shop['service_list'] = $serviceList;

			$products = $this->db->get_where('shop_products',['shop' => $this->input->post('shop'),'type' => 'product'])->result_array();
			$productList = [];
			foreach ($products as $key => $value) {
				$this->db->where('id',$value['id']);
				$data = $this->db->get('shop_products')->row_array();
				$images = [];
				foreach ($this->db->get_where('shop_product_image',['product' => $value['id']])->result_array() as $Ikey => $Ivalue) {
					array_push($images,['image' => base_url('uploads/product/').$Ivalue['image'],'id' => $Ivalue['id']]);
				}
				$value['images'] = $images;
				array_push($productList, $value);
			}
			$shop['product_list'] = $productList;

	    	$category = $this->db->get_where('categories',['id' => $shop['services']])->row_array();
	    	if($category){
		    	$category['image']	= $this->general_model->getCategoryThumb($shop['services']);
		    }
	    	$shop['cate_ob'] = $category;

			retJson(['_return' => true,'data' => $shop]);
		}else{
			retJson(['_return' => false,'msg' => '`shop` are Required']);
		}
	}

	public function getshops()
	{
		if($this->input->post('user')){	
			$this->db->where('user',$this->input->post('user'));
			$this->db->where('df','');
			$list = $this->db->get('shop')->result_array();

			foreach ($list as $key => $value) {
				$prod = $this->shop_model->getShop($value['id']);
				$list[$key] = $prod;
			}

			retJson(['_return' => true,'list' => $list]);
		}else{
			retJson(['_return' => false,'msg' => '`user` are Required']);
		}
	}

	public function delete_shop()
	{
		if($this->input->post('shop')){
			$this->db->where('id',$this->input->post('shop'))->update('shop_products',['df' => 'yes']);
			$this->db->where('id',$this->input->post('shop'))->update('shop',['df' => 'yes']);
			retJson(['_return' => true,'msg' => 'Shop Deleted']);
		}else{
			retJson(['_return' => false,'msg' => '`shop` are Required']);
		}	
	}

	public function edit_shop()
	{
		if($this->input->post('shop') && $this->input->post('user') && $this->input->post('type') && $this->input->post('address') && $this->input->post('lat') && $this->input->post('lon') && $this->input->post('shop_type')  && $this->input->post('services')  && $this->input->post('desc') && $this->input->post('images') && $this->input->post('title') && $this->input->post('bathroom') && $this->input->post('entrance') && $this->input->post('getting_around') && $this->input->post('elevator') && $this->input->post('parking')){
			$instaUrl = ""; $webUrl = "";
			if ($this->input->post('url_insta')) {
				$instaUrl = $this->input->post('url_insta');
			}
			if ($this->input->post('url_web')) {
				$webUrl = $this->input->post('url_web');
			}
			$data = [
				'title'				=> $this->input->post('title'),
				'type'				=> $this->input->post('type'),
				'address'			=> $this->input->post('address'),
				'lat'				=> roundLatLon($this->input->post('lat')),
				'lon'				=> roundLatLon($this->input->post('lon')),
				'shop_type'			=> $this->input->post('shop_type'),
				'services'			=> $this->input->post('services'),
				'descr'				=> $this->input->post('desc'),
				'bathroom'			=> $this->input->post('bathroom'),
				'entrance'			=> $this->input->post('entrance'),
				'getting_around'	=> $this->input->post('getting_around'),
				'elevator'			=> $this->input->post('elevator'),
				'parking'			=> $this->input->post('parking'),
				'url_insta'			=> $instaUrl,
				'url_web'			=> $webUrl
			];
			$this->db->where('id',$this->input->post('shop'))->update('shop',$data);
			$shopId = $this->input->post('shop');
			foreach ($this->input->post('images') as $ikey => $ivalue) {
				$img = $ivalue;
				$img = str_replace('data:image/png;base64,', '', $img);
				$img = str_replace(' ', '+', $img);
				$data = base64_decode($img);
				$file = microtime(true).'.png';
				file_put_contents('./uploads/shop/'.$file, $data);		
				$img = [
					'image'		=> $file,
					'shop'		=> $shopId,
					'user'		=> $this->input->post('user')
				];
				$this->db->insert('shop_images',$img);
			}

			foreach (explode(',', $this->input->post('delete_images')) as $key => $value) {
				$this->db->where('id',$value)->delete('shop_images');
			}
			retJson(['_return' => true,'msg' => 'Shop Updated','shop' => $shopId]);
		}else{
			retJson(['_return' => false,'msg' => '`shop`,`title`,`user`,`type`(retail),`address`,`lat`,`lon`,`shop_type`(products,services,both),`services`(if multiple add comma saprated(1,2,3)),`desc`,`bathroom`,`entrance`,`getting_around`,`elevator`,`parking` are Required,`images` (base64 images index like `images[]`) and `delete_images`(add comma saprated ids of image like 1,2,3) ,`url_insta`,`url_web` are optional']);
		}	
	}

	public function create()
	{
		if($this->input->post('user') && $this->input->post('type') && $this->input->post('address') && $this->input->post('lat') && $this->input->post('lon') && $this->input->post('shop_type')  && $this->input->post('services')  && $this->input->post('desc') && $this->input->post('images') && $this->input->post('title') && $this->input->post('bathroom') && $this->input->post('entrance') && $this->input->post('getting_around') && $this->input->post('elevator') && $this->input->post('parking')){
			$instaUrl = ""; $webUrl = "";
			if ($this->input->post('url_insta')) {
				$instaUrl = $this->input->post('url_insta');
			}
			if ($this->input->post('url_web')) {
				$webUrl = $this->input->post('url_web');
			}
			$data = [
				'shopid'			=> $this->general_model->getShopId(),
				'title'				=> $this->input->post('title'),
				'user'				=> $this->input->post('user'),
				'type'				=> $this->input->post('type'),
				'address'			=> $this->input->post('address'),
				'lat'				=> roundLatLon($this->input->post('lat')),
				'lon'				=> roundLatLon($this->input->post('lon')),
				'shop_type'			=> $this->input->post('shop_type'),
				'services'			=> $this->input->post('services'),
				'descr'				=> $this->input->post('desc'),
				'bathroom'			=> $this->input->post('bathroom'),
				'entrance'			=> $this->input->post('entrance'),
				'getting_around'	=> $this->input->post('getting_around'),
				'elevator'			=> $this->input->post('elevator'),
				'parking'			=> $this->input->post('parking'),
				'url_insta'			=> $instaUrl,
				'url_web'			=> $webUrl,
				'df'				=> '',
				'cat'				=> _nowDateTime()
			];
			$this->db->insert('shop',$data);
			$shopId = $this->db->insert_id();
			foreach ($this->input->post('images') as $ikey => $ivalue) {
				$img = $ivalue;
				$img = str_replace('data:image/png;base64,', '', $img);
				$img = str_replace(' ', '+', $img);
				$data = base64_decode($img);
				$file = microtime(true).'.png';
				file_put_contents('./uploads/shop/'.$file, $data);		
				$img = [
					'image'		=> $file,
					'shop'		=> $shopId,
					'user'		=> $this->input->post('user')
				];
				$this->db->insert('shop_images',$img);
			}

			
			$data = [];
			if($this->input->post('monday_from')){
				$data['monday_from']	= $this->input->post('monday_from');
			}else{
				$data['monday_from'] 	= NULL;
			}
			if($this->input->post('monday_to')){
				$data['monday_to']	= $this->input->post('monday_to');
			}else{
				$data['monday_to'] 	= NULL;
			}
			if($this->input->post('tuesday_from')){
				$data['tuesday_from']	= $this->input->post('tuesday_from');
			}else{
				$data['tuesday_from'] 	= NULL;
			}
			if($this->input->post('tuesday_to')){
				$data['tuesday_to']	= $this->input->post('tuesday_to');
			}else{
				$data['tuesday_to'] 	= NULL;
			}
			if($this->input->post('wednesday_from')){
				$data['wednesday_from']	= $this->input->post('wednesday_from');
			}else{
				$data['wednesday_from'] 	= NULL;
			}
			if($this->input->post('wednesday_to')){
				$data['wednesday_to']	= $this->input->post('wednesday_to');
			}else{
				$data['wednesday_to'] 	= NULL;
			}
			if($this->input->post('thursday_from')){
				$data['thursday_from']	= $this->input->post('thursday_from');
			}else{
				$data['thursday_from'] 	= NULL;
			}
			if($this->input->post('thursday_to')){
				$data['thursday_to']	= $this->input->post('thursday_to');
			}else{
				$data['thursday_to'] 	= NULL;
			}
			if($this->input->post('friday_from')){
				$data['friday_from']	= $this->input->post('friday_from');
			}else{
				$data['friday_from'] 	= NULL;
			}
			if($this->input->post('friday_to')){
				$data['friday_to']	= $this->input->post('friday_to');
			}else{
				$data['friday_to'] 	= NULL;
			}
			if($this->input->post('saturday_from')){
				$data['saturday_from']	= $this->input->post('saturday_from');
			}else{
				$data['saturday_from'] 	= NULL;
			}
			if($this->input->post('saturday_to')){
				$data['saturday_to']	= $this->input->post('saturday_to');
			}else{
				$data['saturday_to'] 	= NULL;
			}
			if($this->input->post('sunday_from')){
				$data['sunday_from']	= $this->input->post('sunday_from');
			}else{
				$data['sunday_from'] 	= NULL;
			}
			if($this->input->post('sunday_to')){
				$data['sunday_to']	= $this->input->post('sunday_to');
			}else{
				$data['sunday_to'] 	= NULL;
			}

			$data['shop']	= $shopId;
			$this->db->insert('shop_timing',$data);
			retJson(['_return' => true,'msg' => 'Shop Created','shop' => $shopId]);

		}else{
			retJson(['_return' => false,'msg' => '`title`,`user`,`type`(retail),`address`,`lat`,`lon`,`shop_type`(products,services,both),`services`(if multiple add comma saprated(1,2,3)),`desc` and `images` (base64 images index like `images[]`),`bathroom`,`entrance`,`getting_around`,`elevator`,`parking` are Required,`url_insta`,`url_web`,`monday_from`,`monday_to`,`tuesday_from`,`tuesday_to`,`wednesday_from`,`wednesday_to`,`thursday_from`,`thursday_to`,`friday_from`,`friday_to`,`saturday_from`,`saturday_to`,`sunday_from`,`sunday_to` are optional']);
		}
	}
}