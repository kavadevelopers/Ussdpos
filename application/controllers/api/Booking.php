<?php
class Booking extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('stripelib');
	}

	public function change_date_time_of_waiting_booking()
	{
		if($this->input->post('booking') && $this->input->post('date') && $this->input->post('time')){
			$date = NULL; $time = NULL;
			if($this->input->post('date')){ $date = dd($this->input->post('date')); }
			if($this->input->post('time')){ $time = dt($this->input->post('time')); }
			$data = [
				'dt'		=> $date,
				'tm'		=> $time,
				'status'	=> '1'
			];
			$this->db->where('id',$this->input->post('booking'))->update('booking_queue',$data);			
			retJson(['_return' => true,'msg' => "Time Updated"]);
		}else{
			retJson(['_return' => false,'msg' => '`booking`,`date`,`time` are Required']);
		}
	}

	public function reject_by_customer()
	{
		if($this->input->post('booking')){	
			$this->db->where('id',$this->input->post('booking'))->delete('booking_queue');
			retJson(['_return' => true,'msg' => "Rejected"]);
		}else{
			retJson(['_return' => false,'msg' => '`booking` are Required']);
		}	
	}

	public function accept_booking_customer()
	{
		if($this->input->post('booking')){	
			
			$booking = $this->db->get_where('booking_queue',['id' => $this->input->post('booking')])->row_array();			
			$data = [
				'shop'		=> $booking['shop'],
				'type'		=> 'service',
				'user'		=> $booking['user'],
				'service'	=> $booking['service'],
				'product'	=> $booking['product'],
				'qty'		=> '1',
				'price'		=> $booking['price'],
				'subtotal'	=> $booking['price'],
				'dt'		=> $booking['dt'],
				'tm'		=> $booking['tm'],
				'booking'	=> "",
				'cat'		=> _nowDateTime()
			];
			$this->db->insert('booking_products',$data);

			$this->db->where('id',$this->input->post('booking'))->delete('booking_queue');
			retJson(['_return' => true,'msg' => "item added to cart."]);
		}else{
			retJson(['_return' => false,'msg' => '`booking` are Required']);
		}
	}

	public function get_queue_customer_side()
	{
		if($this->input->post('user')){	
			
			$list = $this->db->get_where('booking_queue',['user' => $this->input->post('user')])->result_array();
			foreach ($list as $key => $value) {
				$list[$key]['provider_ob'] = $this->service_model->getServiceData($value['service']);
				$list[$key]['product_ob'] = $this->shop_model->getProduct($value['product']);
				$list[$key]['customer_ob'] = $this->customer_model->getCustomerData($value['user']);
				$list[$key]['queue_counter']	= $this->db->get_where('booking_queue',['id <' => $value['id']])->num_rows();
			}

			retJson(['_return' => true,'list' => $list]);
		}else{
			retJson(['_return' => false,'msg' => '`user` are Required']);
		}
	}	

	public function get_queue_provider_side()
	{
		if($this->input->post('user')){	

			$list = $this->db->get_where('booking_queue',['service' => $this->input->post('user'),'status' => '0'])->result_array();
			foreach ($list as $key => $value) {
				$list[$key]['product_ob'] = $this->shop_model->getProduct($value['product']);
				$list[$key]['customer_ob'] = $this->customer_model->getCustomerData($value['user']);
			}

			retJson(['_return' => true,'list' => $list]);
		}else{
			retJson(['_return' => false,'msg' => '`user` are Required']);
		}
	}

	public function add_in_queue()
	{
		if($this->input->post('user') && $this->input->post('service') && $this->input->post('product') && $this->input->post('date') && $this->input->post('time')){
			$date = NULL; $time = NULL;
			if($this->input->post('date')){ $date = dd($this->input->post('date')); }
			if($this->input->post('time')){ $time = dt($this->input->post('time')); }
			$prod = $this->db->get_where('shop_products',['id' => $this->input->post('product')])->row_array();
			$data = [
				'shop'		=> $prod['shop'],
				'type'		=> 'service',
				'user'		=> $this->input->post('user'),
				'service'	=> $this->input->post('service'),
				'product'	=> $this->input->post('product'),
				'qty'		=> '1',
				'price'		=> $prod['price'],
				'dt'		=> $date,
				'tm'		=> $time,
				'status'	=> 0,
				'cat'		=> _nowDateTime()
			];
			$this->db->insert('booking_queue',$data);
			retJson(['_return' => true,'msg' => "item added to queue."]);
		}else{
			retJson(['_return' => false,'msg' => '`user`,`service`,`product`,`qty`,`date`,`time` are Required']);
		}	
	}

	public function send_tip()
	{
		if($this->input->post('booking') && $this->input->post('provider') && $this->input->post('customer') && $this->input->post('amount') && $this->input->post('percentage') && $this->input->post('card_id')){	

			$customer = $this->customer_model->getCustomerData($this->input->post('customer'));
			if($customer){
				if($customer['stripeclient'] != '' && $customer['stripeclient'] != NULL){

					$chargeClient = $this->stripelib->chargeClient(
						$this->input->post('amount'),
						$customer['stripeclient'],
						$this->input->post('card_id')
					);

					if($chargeClient){

						$data = [
							'booking'		=> $this->input->post('booking'),
							'provider'		=> $this->input->post('provider'),
							'customer'		=> $this->input->post('customer'),
							'amount'		=> $this->input->post('amount'),
							'percentage'	=> $this->input->post('percentage'),
							'card_id'		=> $this->input->post('card_id'),
							'cat'			=> _nowDateTime()
						];
						$this->db->insert('booking_tip',$data);

						retJson(['_return' => true,'msg' => "Tip Sent"]);
					}else{
						retJson(['_return' => false,'msg' => 'Error in Charge Client - '.$this->stripelib->api_error]);
					}
				}else{
					retJson(['_return' => false,'msg' => 'Client Not Created in stripe']);
				}
			}else{
				retJson(['_return' => false,'msg' => 'Client Not found']);
			}

		}else{
			retJson(['_return' => false,'msg' => '`booking`,`provider`,`customer`,`amount`,`percentage`,`card_id` are Required']);
		}
	}

	public function get_bookings_of_service_provider(){
		if($this->input->post('date') && $this->input->post('provider')){
			$oldBookings = $this->db->get_where('booking_products',[
				'service' => $this->input->post('provider'),'dt' => $this->input->post('date')
			])->result_array();

			$dateTime = [];
			foreach ($oldBookings as $key => $value) {
				array_push($dateTime, 
					[
						'book_date' 		=> $value['dt'], 
						'book_time' 		=> $value['tm'], 
						'service_duration' 	=> $this->db->get_where('shop_products',['id' => $value['product']])->row_array()['duration'], 
						'open_close'		=> $this->db->get_where('service_timing',['service' => $this->input->post('provider')])->row_array()
					]
				);
			}

			retJson(['_return' => true,'list' => $dateTime]);
		}else{
			retJson(['_return' => false,'msg' => '`date`(YYYY-MM-DD),`provider` are Required']);
		}
	}

	public function get_suggested_items(){
		if($this->input->post('user')){
			$cartList = $this->db->get_where('booking_products',['booking' => '','user' => $this->input->post('user'),'type' => 'product'])->result_array();
			$categories = []; $prods = [];
			foreach ($cartList as $key => $value) {
				$prod = $this->db->get_where('shop_products',['id' => $value['product']])->row_array();
				if($prod){
					array_push($categories, $prod['category']);
					array_push($prods, $prod['id']);
				}
			}

			if(count($prods) > 0 && count($categories) > 0){
				$this->db->limit(10);
				$this->db->where_not_in('id',$prods);
				$this->db->where_in('category',$categories);
				$this->db->where('df','');
				$this->db->where('block','no');
				$this->db->where('type','product');
				$prodList = $this->db->get('shop_products')->result_array();
				$list = [];
				foreach ($prodList as $key => $value) {
					$prod = $this->shop_model->getProduct($value['id'],$this->input->post('user'));
					array_push($list, $prod);
				}
			}else{
				$list = [];
			}
			retJson(['_return' => true,'list' => $list]);	
		}else{
			retJson(['_return' => false,'msg' => '`user` are Required']);
		}	
	}

	public function reorder()
	{
		if ($this->input->post('booking') && $this->input->post('user')) {
			$bookings = $this->db->get_where('booking_products',['booking' => $this->input->post('booking')])->result_array();

			foreach ($bookings as $key => $booking) {
				if ($booking['type'] == "product") {
					$prod = $this->db->get_where('shop_products',['id' => $booking['product']])->row_array();
					$data = [
						'shop'		=> $prod['shop'],
						'type'		=> "product",
						'user'		=> $this->input->post('user'),
						'service'	=> $booking['service'],
						'product'	=> $booking['product'],
						'qty'		=> $booking['qty'],
						'price'		=> $prod['price'],
						'subtotal'	=> $prod['price'] * $booking['qty'],
						'booking'	=> "",
						'cat'		=> _nowDateTime()
					];
					$this->db->insert('booking_products',$data);
				}else{
					$date = NULL; $time = NULL;
					if($booking['dt']){ $date = dd($booking['dt']); }
					if($booking['tm']){ $time = dt($booking['tm']); }
					$prod = $this->db->get_where('shop_products',['id' => $booking['product']])->row_array();
					$data = [
						'shop'		=> $prod['shop'],
						'type'		=> "service",
						'user'		=> $this->input->post('user'),
						'service'	=> $booking['service'],
						'product'	=> $booking['product'],
						'qty'		=> $booking['qty'],
						'price'		=> $prod['price'],
						'subtotal'	=> $prod['price'] * $booking['qty'],
						'dt'		=> $date,
						'tm'		=> $time,
						'booking'	=> "",
						'cat'		=> _nowDateTime()
					];
					$this->db->insert('booking_products',$data);
				}
			}	

			retJson(['_return' => true,'msg' => 'Items Added To Cart.']);				
		}else{
			retJson(['_return' => false,'msg' => '`booking`,`user` are Required']);
		}	
	}

	public function booking_status()
	{
		if ($this->input->post('booking') && $this->input->post('status')) {
			$booking = $this->db->get_where('booking',['id' => $this->input->post('booking')])->row_array();
			if ($this->input->post('status') == "accept") {
				$this->db->where('id',$this->input->post('booking'));
				$this->db->update('booking',['status' => 'ongoing']);


				$this->general_model->customerPush(
					$booking['user'],
					'Booking #'.$booking['booking'],
					"Booking Accepted by provider",
					"booking",
					['booking' => $this->input->post('booking')]	
				);

				retJson(['_return' => true,'msg' => 'Status Changed.']);
			}else if ($this->input->post('status') == "reject") {
				$this->db->where('id',$this->input->post('booking'));
				$this->db->update('booking',['status' => 'rejected']);

				$this->general_model->customerPush(
					$booking['user'],
					'Booking #'.$booking['booking'],
					"Booking Rejected by provider",
					"booking",
					['booking' => $this->input->post('booking')]	
				);

				retJson(['_return' => true,'msg' => 'Status Changed.']);
			}else if ($this->input->post('status') == "cancel") {
				$this->db->where('id',$this->input->post('booking'));
				$this->db->update('booking',['status' => 'cancelled']);

				$this->general_model->customerPush(
					$booking['user'],
					'Booking #'.$booking['booking'],
					"Booking Cancelled by provider",
					"booking",
					['booking' => $this->input->post('booking')]	
				);

				retJson(['_return' => true,'msg' => 'Status Changed.']);				
			}else if ($this->input->post('status') == "complete") {
				$this->db->where('id',$this->input->post('booking'));
				$this->db->update('booking',['status' => 'completed']);

				$this->general_model->customerPush(
					$booking['user'],
					'Booking #'.$booking['booking'],
					"Booking Complated. Thankyou.",
					"booking",
					['booking' => $this->input->post('booking')]	
				);

				retJson(['_return' => true,'msg' => 'Status Changed.']);				
			}else{
				retJson(['_return' => false,'msg' => 'Not Allowed']);	
			}
		}else{
			retJson(['_return' => false,'msg' => '`booking`,`status`(accept,reject,cancel,complete) are Required']);
		}	
	}

	public function get_bookings_by_date()
	{
		if ($this->input->post('user') && $this->input->post('user_type')) {
			$booking_dates = [];
			$status_array = ['upcoming','ongoing'];
			if ($this->input->post('user_type') == "owner") {
				$booking_dates = [];
				$this->db->distinct();
				$this->db->select('date_of_work');
				$this->db->where('service',$this->input->post('user'));
				$this->db->where_in('status',$status_array);
				$dates = $this->db->get('booking')->result_array();
				foreach ($dates as $key => $value) {
					array_push($booking_dates, $value['date_of_work']);
				}
			}else if($this->input->post('user_type') == "manager"){
				$manager = $this->service_model->getServiceData($this->input->post('user'));
				$booking_dates = [];
				$this->db->distinct();
				$this->db->select('date_of_work');
				$this->db->where('shop',$manager['shop']);
				$this->db->where_in('status',$status_array);
				$dates = $this->db->get('booking')->result_array();
				foreach ($dates as $key => $value) {
					array_push($booking_dates, $value['date_of_work']);
				}
			}else if($this->input->post('user_type') == "provider"){
				$booking_dates = [];
				$this->db->distinct();
				$this->db->select('date_of_work');
				$this->db->where('provider',$this->input->post('user'));	
				$this->db->where_in('status',$status_array);
				$dates = $this->db->get('booking')->result_array();
				foreach ($dates as $key => $value) {
					array_push($booking_dates, $value['date_of_work']);
				}
			}else{
				retJson(['_return' => false,'msg' => 'Not Allowed']);	
				exit;
			}

			if ($this->input->post('date')) {
				$this->db->where('date_of_work',$this->input->post('date'));
			}else{
				$this->db->where_in('date_of_work',$booking_dates);
			}
			if ($this->input->post('user_type') == "owner") {
				$this->db->where('service',$this->input->post('user'));
			}else if($this->input->post('user_type') == "manager"){
				$manager = $this->service_model->getServiceData($this->input->post('user'));
				$this->db->where('shop',$manager['shop']);
			}else if($this->input->post('user_type') == "provider"){
				$this->db->where('provider',$this->input->post('user'));
			}
			$this->db->where_in('status',$status_array);

			$list = $this->db->get('booking')->result_array();
			foreach ($list as $key => $value) {
				$list[$key] = $this->booking_model->getServiceBooking($value['id']);
			}
			retJson(['_return' => true,'dates' => $booking_dates,'list' => $list]);
		}else{
			retJson(['_return' => false,'msg' => '`user`,`user_type`(owner,manager,provider) are Required,`date`(yyyy-mm-dd) is optional']);
		}
	}

	public function get_bookings_customer_side()
	{
		if ($this->input->post('user') && $this->input->post('status')) {
			$this->db->order_by('id','desc');
			$this->db->where('user',$this->input->post('user'));
			if($this->input->post('status') != "all"){
				$this->db->where('status',$this->input->post('status'));
			}
			$list = $this->db->get('booking')->result_array();

			foreach ($list as $key => $value) {
				$list[$key] = $this->booking_model->getServiceBooking($value['id']);
			}

			retJson(['_return' => true,'list' => $list]);
			
		}else{
			retJson(['_return' => false,'msg' => '`user`,`status`(all,upcoming,completed,rejected,cancelled,ongoing) are Required']);
		}
	}

	public function get_bookings_service_side()
	{
		if ($this->input->post('user_type') && $this->input->post('user') && $this->input->post('status') && $this->input->post('type')) {

			if ($this->input->post('type') == "service") {
				if ($this->input->post('user_type') == "owner") {
					$this->db->order_by('id','desc');
					$this->db->where('provider !=',NULL);
					$this->db->where('service',$this->input->post('user'));
					if($this->input->post('status') != "all"){
						$this->db->where('status',$this->input->post('status'));
					}
					$list = $this->db->get('booking')->result_array();
				}else if ($this->input->post('user_type') == "provider") {
					$this->db->order_by('id','desc');
					$this->db->where('provider !=',NULL);
					$this->db->where('provider',$this->input->post('user'));
					if($this->input->post('status') != "all"){
						$this->db->where('status',$this->input->post('status'));
					}
					$list = $this->db->get('booking')->result_array();
				}else if ($this->input->post('user_type') == "manager") {
					if($this->input->post('shop')){
						$this->db->order_by('id','desc');
						$this->db->where('provider !=',NULL);
						$this->db->where('shop',$this->input->post('shop'));
						if($this->input->post('status') != "all"){
							$this->db->where('status',$this->input->post('status'));
						}
						$list = $this->db->get('booking')->result_array();
					}else{
						retJson(['_return' => false,'msg' => '`shop` are Required']);		
						exit;
					}
				}else{
					retJson(['_return' => false,'msg' => 'Not Allowed']);
					exit;
				}
			}else{
				if ($this->input->post('parent')) {
					$this->db->order_by('id','desc');
					$this->db->where('provider',NULL);
					$this->db->where('service',$this->input->post('parent'));
					if($this->input->post('status') != "all"){
						$this->db->where('status',$this->input->post('status'));
					}
					$list = $this->db->get('booking')->result_array();
				}else{
					retJson(['_return' => false,'msg' => '`parent` are Required']);		
					exit;
				}
			}

			foreach ($list as $key => $value) {
				$list[$key] = $this->booking_model->getServiceBooking($value['id']);
			}

			retJson(['_return' => true,'list' => $list]);

		}else{
			retJson(['_return' => false,'msg' => '`type`(product,service),`user_type`(owner,manager,provider),`user`,`status`(all,upcoming,completed,rejected,cancelled,ongoing) are Required']);
		}
	}

	public function get_booking()
	{
		if($this->input->post('booking')){	
			retJson(['_return' => true,"data" => $this->booking_model->getServiceBooking($this->input->post('booking'))]);
		}else{
			retJson(['_return' => false,'msg' => '`booking` are Required']);
		}	
	}

	public function get_card_list()
	{
		if($this->input->post('user')){	
			$customer = $this->customer_model->getCustomerData($this->input->post('user'));
			if($customer){
				if($customer['stripeclient'] != '' && $customer['stripeclient'] != NULL){
					$cardList = $this->stripelib->getCards(
						$customer['stripeclient']
					);		
					if($cardList){
						retJson(['_return' => true,'msg' => 'Card List','data' => $cardList]);	
					}else{
						retJson(['_return' => false,'msg' => 'Error in get card list - '.$this->stripelib->api_error]);	
					}
				}else{
					retJson(['_return' => false,'msg' => 'Client Not Created in stripe']);
				}
			}else{
				retJson(['_return' => false,'msg' => 'Client Not found']);
			}
		}else{
			retJson(['_return' => false,'msg' => '`user` are Required']);
		}	
	}

	public function add_card_to_stripe()
	{
		if($this->input->post('user') && $this->input->post('token')){	
			$customer = $this->customer_model->getCustomerData($this->input->post('user'));
			if($customer){
				if($customer['stripeclient'] != '' && $customer['stripeclient'] != NULL){
					$strSource = $this->stripelib->assignCard(
						$customer['stripeclient'],
						$this->input->post('token')
					);		
					if($strSource){
						retJson(['_return' => true,'msg' => 'Card Assigned.','data' => $strSource]);	
					}else{
						retJson(['_return' => false,'msg' => 'Error in assign card - '.$this->stripelib->api_error]);	
					}
				}else{
					retJson(['_return' => false,'msg' => 'Client Not Created in stripe']);
				}
			}else{
				retJson(['_return' => false,'msg' => 'Client Not found']);
			}
		}else{
			retJson(['_return' => false,'msg' => '`user`,`token`(stripe card token) are Required']);
		}
	}

	public function modify_cart()
	{
		if($this->input->post('user') && $this->input->post('cart') && $this->input->post('qty')){
			if($this->input->post('qty') != "0.00"){
				$cart = $this->db->get_where('booking_products',['id' => $this->input->post('cart')])->row_array();
				$this->db->where('id',$this->input->post('cart'))->update('booking_products',['qty' => $this->input->post('qty'),'subtotal' => $this->input->post('qty') * $cart['price']]);
			}else{
				$this->db->where('id',$this->input->post('cart'))->delete('booking_products');
			}
			retJson(['_return' => true,'msg' => "Cart Updated"]);
		}else{
			retJson(['_return' => false,'msg' => '`user`,`cart`,`qty`(put decimal values here like 0.00,1.00,...9.00) are Required']);
		}
	}

	public function getcart()
	{
		if($this->input->post('user')){
			$promocode = false;
			if($this->input->post('promocode')){
				$promocode = $this->input->post('promocode');
			}


			$list = $this->db->get_where('booking_products',['booking' => '','user' => $this->input->post('user')])->num_rows();
			if($list > 0){
				$list = $this->shop_model->getCart($this->input->post('user'),$promocode);
			}else{
				$list = ['cart' => [],'promo' => ['added' => 'no']];
			}

			$total = 0; $subtotal = 0; $discount = 0; $prodDiscount = 0; $tax = 0; $shipping_charge = 0;

			foreach ($list['cart'] as $key => $value) {
				$subtotal 			+= $value['subtotal'];
				$discount 			+= $value['discount'];
				$prodDiscount 		+= $value['product_discount'];
				$tax 				+= $value['tax'];
				$shipping_charge 	+= $value['shipping_charge'];
				$total 				+= ($value['subtotal'] + $value['tax']) - ($value['product_discount'] + $value['discount']) + $value['shipping_charge'];
			}

			$promoList = [];
			$disShops = getDistinctShopFromCart($this->input->post('user'));
			if(count($disShops) > 0){
				foreach ($disShops as $key => $value) {
					$promos = $this->db->get_where('promocodes',['shop' => $value,'df' => '','active' => 'yes'])->result_array();
					foreach ($promos as $pkey => $pvalue) {
						array_push($promoList, $pvalue)	;
					}
				}
			}

			$data = [
				'_return'	=> true,
				'count'		=> count($list['cart']),
				'list'		=> $list['cart'],
				'promo'		=> $list['promo'],
				'subtotal'	=> formatTwoDecimal($subtotal),
				'total'		=> formatTwoDecimal($total),
				'discount'	=> formatTwoDecimal($discount),
				'pdiscount'	=> formatTwoDecimal($prodDiscount),
				'tax'		=> formatTwoDecimal($tax),
				'shipping_charge'	=> formatTwoDecimal($shipping_charge),
				'promo_list'	=> $promoList
			];
			retJson($data);
		}else{
			retJson(['_return' => false,'msg' => '`user` are Required,`promocode` is optional']);
		}	
	}

	public function removecart()
	{
		if($this->input->post('cart')){
			$this->db->where('id',$this->input->post('cart'))->delete('booking_products');
			retJson(['_return' => true,'msg' => "item removed from cart."]);
		}else{
			retJson(['_return' => false,'msg' => '`cart` is Required']);
		}
	}

	public function change_date_time()
	{
		if ($this->input->post('cart') && $this->input->post('date') && $this->input->post('time')) {
			$this->db->where('id',$this->input->post('cart'))->update('booking_products',['dt' => dd($this->input->post('date')),'tm' => dt($this->input->post('time'))]);
			retJson(['_return' => true,'msg' => "item updated"]);
		}else{
			retJson(['_return' => false,'msg' => '`cart`,`date`,`time` are Required']);
		}
	}

	public function addtocart()
	{
		if ($this->input->post('type')) {
			if ($this->input->post('type') == "service") {
				if($this->input->post('user') && $this->input->post('service') && $this->input->post('product') && $this->input->post('qty')){
					$cartChk = $this->db->get_where('booking_products',['user' => $this->input->post('user'),'product' => $this->input->post('product'),'booking' => ''])->row_array();
					if (!$cartChk) {
						$date = NULL; $time = NULL;
						if($this->input->post('date')){ $date = dd($this->input->post('date')); }
						if($this->input->post('time')){ $time = dt($this->input->post('time')); }
						$prod = $this->db->get_where('shop_products',['id' => $this->input->post('product')])->row_array();
						$data = [
							'shop'		=> $prod['shop'],
							'type'		=> $this->input->post('type'),
							'user'		=> $this->input->post('user'),
							'service'	=> $this->input->post('service'),
							'product'	=> $this->input->post('product'),
							'qty'		=> $this->input->post('qty'),
							'price'		=> $prod['price'],
							'subtotal'	=> $prod['price'] * $this->input->post('qty'),
							'dt'		=> $date,
							'tm'		=> $time,
							'booking'	=> "",
							'cat'		=> _nowDateTime()
						];
						$this->db->insert('booking_products',$data);
						retJson(['_return' => true,'msg' => "item added to cart."]);	
					}else{
						retJson(['_return' => false,'msg' => "item already in cart."]);	
					}
				}else{
					retJson(['_return' => false,'msg' => '`user`,`service`,`product`,`qty` are Required,Optional parameters are `date`,`time`']);
				}					
			}else if ($this->input->post('type') == "product") {
				if($this->input->post('user') && $this->input->post('service') && $this->input->post('product') && $this->input->post('qty') && $this->input->post('shop')){
					if($this->input->post('replace')){
						$this->db->where('type','product')->where('user',$this->input->post('user'))->where('booking','')->delete('booking_products');
					}
					$prod = $this->db->get_where('shop_products',['id' => $this->input->post('product')])->row_array();
					$data = [
						'shop'		=> $prod['shop'],
						'type'		=> $this->input->post('type'),
						'user'		=> $this->input->post('user'),
						'service'	=> $this->input->post('service'),
						'product'	=> $this->input->post('product'),
						'qty'		=> $this->input->post('qty'),
						'price'		=> $prod['price'],
						'subtotal'	=> $prod['price'] * $this->input->post('qty'),
						'booking'	=> "",
						'cat'		=> _nowDateTime()
					];
					$this->db->insert('booking_products',$data);
					retJson(['_return' => true,'msg' => "item added to cart."]);
				}else{	
					retJson(['_return' => false,'msg' => '`user`,`service`,`product`,`qty`,`shop` are Required,Optional parameters are `replace`(replace old items or remove old items)']);
				}
			}else{
				retJson(['_return' => false,'msg' => '`type` not found']);
			}
		}else{
			retJson(['_return' => false,'msg' => '`type`(service,product) is Required']);
		}
	}



	public function book()
	{
		if($this->input->post('user') && $this->input->post('totalamount') && $this->input->post('card_id') && $this->input->post('savecard')){	
			$customer = $this->customer_model->getCustomerData($this->input->post('user'));
			if($customer){
				if($customer['stripeclient'] != '' && $customer['stripeclient'] != NULL){

					$chargeClient = $this->stripelib->chargeClient(
						$this->input->post('totalamount'),
						$customer['stripeclient'],
						$this->input->post('card_id')
					);

					$promo_code = "";
					if ($this->input->post('promo_code')) {
						$promo_code = $this->input->post('promo_code');
					}

					if($chargeClient){

						if($this->input->post('savecard') == 'no'){
							$deleteCard = $this->stripelib->deleteCard(
								$customer['stripeclient'],
								$this->input->post('card_id')
							);
						}

						
						$bookings = $this->booking_model->order(
							$this->input->post('user'),
							$chargeClient->source->brand,
							$chargeClient->source->last4,
							$this->input->post('card_id'),
							$promo_code
						);


						retJson(['_return' => true,'msg' => "Booking Done","detail" => $bookings]);
					}else{
						retJson(['_return' => false,'msg' => 'Error in Charge Client - '.$this->stripelib->api_error]);
					}
				}else{
					retJson(['_return' => false,'msg' => 'Client Not Created in stripe']);
				}
			}else{
				retJson(['_return' => false,'msg' => 'Client Not found']);
			}
		}else{
			retJson(['_return' => false,'msg' => '`user`,`totalamount`,`savecard`(yes,no) and `card_id` is Required,`promo_code` are optional']);
		}
	}
}

