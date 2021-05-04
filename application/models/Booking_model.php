<?php
class Booking_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function order($user,$cardBrand,$last4,$card_id,$promoId = false)
	{
		$bookings = [];
		$shops = getDistinctShopFromCart($user);
		if ($promoId) {
			$promoCode = getPromoAmount($promoId,$user,$shops);
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
			$promoAutoId = $promoCode['id'];
		}else{
			$promoAutoId = "";
		}

		$this->db->where('type','service');
		$this->db->where('booking','');
		$this->db->where('user',$this->input->post('user'));
		$cart = $this->db->get('booking_products')->result_array();
		foreach ($cart as $key => $cSingle) {
			$prodDisSingle = 0; $discSingle = 0; $taxSingle = 0; $subTotalSingle = $cSingle['subtotal'];
			$disCount = $this->db->get_where('promo_prods',['service' => $cSingle['service'],'prods' => $cSingle['qty']])->row_array();
			if($disCount && $cSingle['type'] == 'product'){
				$prodDisSingle = $cSingle['subtotal'] * $disCount['percentage'] / 100;
				$this->db->where('id',$cSingle['id'])->update('booking_products',['product_discount' => $prodDisSingle]);
			}

			if($promoCode && $promoCode['shop'] == $cSingle['shop']){
				$discSingle = getDiscountAfter($promoCode['amount'],$cSingle['subtotal'],$disconutAmount);
				$this->db->where('id',$cSingle['id'])->update('booking_products',['discount' => $discSingle]);
			}

			if($cSingle['type'] == "product"){
				$taxSingle = getTax($cSingle['subtotal'],get_setting()['prod_tax']);
				$this->db->where('id',$cSingle['id'])->update('booking_products',['tax' => $taxSingle]);
			}else{
				$taxSingle = getTax($cSingle['subtotal'],get_setting()['serv_tax']);
				$this->db->where('id',$cSingle['id'])->update('booking_products',['tax' => $taxSingle]);
			}

			$totalSingle = (($subTotalSingle + $taxSingle) - $discSingle) - $prodDisSingle;
			$this->db->where('id',$cSingle['id'])->update('booking_products',['total' => $totalSingle]);

			$shopData = $this->db->get_where('shop',['id' => $cSingle['shop']])->row_array();
			$data = [
				'booking'			=> getBookingId(),
				'user'				=> $user,
				'service'			=> $shopData['user'],
				'shop'				=> $cSingle['shop'],
				'subtotal'			=> $subTotalSingle,
				'prod_discount'		=> $prodDisSingle,
				'tax'				=> $taxSingle,
				'promo_amount'		=> $discSingle,
				'total'				=> $totalSingle,
				'promo_id'			=> $promoAutoId,
				'card'				=> $cardBrand,
				'lastfour'			=> $last4,
				'card_id'			=> $card_id,
				'status'			=> 'upcoming',
				'cat'				=> _nowDateTime()
			];
			$this->db->insert('booking',$data);
			$booking = $this->db->insert_id();
			$this->db->where('id',$cSingle['id'])->update('booking_products',['booking' => $booking]);

			$service = $this->db->get_where('booking_products',['booking' => $booking])->row_array();
			if($service){
				$this->db->where('id',$booking)->update('booking',['provider' => $service['service'],'date_of_work' => $service['dt']]);
			}
			array_push($bookings, ['booking' => $this->booking_model->getServiceBooking($booking)]);
		}
		$shops = getDistinctShopFromCart($user);
		foreach ($shops as $key => $shop) {
			$shopData = $this->db->get_where('shop',['id' => $shop])->row_array();
			$total = 0; $subTotal = 0; $disTotal = 0; $prodDisTotal = 0; $taxTotal = 0; $shippingChargeTotal = 0;
			$cart = $this->db->get_where('booking_products',['shop' => $shop,'booking' => '','type' => 'product'])->result_array();		
			foreach ($cart as $cKey => $cSingle) {
				$prodSingleRow = $this->shop_model->getProduct($cSingle['product']);
				$prodDisSingle = 0; $discSingle = 0; $taxSingle = 0; $subTotalSingle = $cSingle['subtotal']; $shippingCharge = $prodSingleRow['shipping_charge'];
				$disCount = $this->db->get_where('promo_prods',['service' => $cSingle['service'],'prods' => $cSingle['qty']])->row_array();
				if($disCount && $cSingle['type'] == 'product'){
					$prodDisSingle = $cSingle['subtotal'] * $disCount['percentage'] / 100;
					$this->db->where('id',$cSingle['id'])->update('booking_products',['product_discount' => $prodDisSingle]);
					$prodDisTotal += $prodDisSingle;						
				}

				if($promoCode && $promoCode['shop'] == $cSingle['shop']){
					$discSingle = getDiscountAfter($promoCode['amount'],$cSingle['subtotal'],$disconutAmount);
					$this->db->where('id',$cSingle['id'])->update('booking_products',['discount' => $discSingle]);
					$disTotal += $discSingle;	
				}

				if($cSingle['type'] == "product"){
					$taxSingle = getTax($cSingle['subtotal'],get_setting()['prod_tax']);
					$this->db->where('id',$cSingle['id'])->update('booking_products',['tax' => $taxSingle]);
					$taxTotal += $taxSingle;
				}

				$subTotal += $cSingle['subtotal'];	
				$totalSingle = (($subTotalSingle + $taxSingle) - $discSingle) - $prodDisSingle + $shippingCharge;
				$shippingChargeTotal += $shippingCharge;
				$this->db->where('id',$cSingle['id'])->update('booking_products',['total' => $totalSingle]);
				$this->db->where('id',$cSingle['id'])->update('booking_products',['shipping' => $shippingCharge]);
				$total += $totalSingle;
			}


			$data = [
				'booking'			=> getBookingId(),
				'user'				=> $user,
				'service'			=> $shopData['user'],
				'shop'				=> $shop,
				'subtotal'			=> $subTotal,
				'prod_discount'		=> $prodDisTotal,
				'tax'				=> $taxTotal,
				'promo_amount'		=> $disTotal,
				'shipping'			=> $shippingChargeTotal,
				'total'				=> $total,
				'promo_id'			=> $promoAutoId,
				'card'				=> $cardBrand,
				'lastfour'			=> $last4,
				'card_id'			=> $card_id,
				'status'			=> 'upcoming',
				'cat'				=> _nowDateTime()
			];
			$this->db->insert('booking',$data);
			$booking = $this->db->insert_id();
			$this->db->where('user',$this->input->post('user'))->where('shop',$shop)->where('booking','')->where('type','product')->update('booking_products',['booking' => $booking]);

			array_push($bookings, ['booking' => $this->booking_model->getServiceBooking($booking)]);
		}


		return $bookings;
	}

	public function getServiceBooking($booking)
	{
		$booking = $this->db->get_where('booking',['id' => $booking])->row_array();	
		$booking['user']		= $this->customer_model->getCustomerData($booking['user']);
		$booking['service']		= $this->service_model->getServiceData($booking['service']);
		if($booking['provider'] != null || $booking['provider'] != ""){
		    $booking['provider']	= $this->service_model->getServiceData($booking['provider']);
		}
		$booking['shop']	= $this->shop_model->getShop($booking['shop']);
		
		$bookings = $this->db->get_where('booking_products',['booking' => $booking['id']])->result_array();
		$services = [];
		foreach ($bookings as $key => $value) {
			
			$value['service']	= $this->service_model->getServiceData($value['service']);
			$value['product']	= $this->shop_model->getProduct($value['product'],$booking['user']['id']);

			array_push($services, $value);
		}
		$booking['services'] 	= $services;
		$booking['customer_support_phone'] 	= get_setting()['customer_support_phone'];
		$booking['additional_rules'] 		= get_setting()['shop_rule'];
		return $booking;
	}


}