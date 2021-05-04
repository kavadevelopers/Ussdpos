<?php
class Ratings extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_all_reviews()
	{
		if($this->input->post('type')){

			if ($this->input->post('type') == "customer") {
				if($this->input->post('customer')){
					$reviews = $this->db->get_where('customer_review',['customer' => $this->input->post('customer')])->result_array();
					$reviewsList = [];
					foreach ($reviews as $key => $value) {
						$value['provider_ob']	= $this->service_model->getServiceData($value['provider']);
						array_push($reviewsList, $value);
					}
					retJson(['_return' => true,'data' => $reviewsList]);
				}else{
					retJson(['_return' => false,'msg' => '`customer` are Required']);		
				}				
			}else if ($this->input->post('type') == "provider") {
				if($this->input->post('provider')){
					$reviews = $this->db->get_where('service_review',['provider' => $this->input->post('provider')])->result_array();
					$reviewsList = [];
					foreach ($reviews as $key => $value) {
						$value['customer_ob']	= $this->customer_model->getCustomerData($value['customer']);
						array_push($reviewsList, $value);
					}
					retJson(['_return' => true,'data' => $reviewsList]);
				}else{
					retJson(['_return' => false,'msg' => '`provider` are Required']);		
				}				
			} else if ($this->input->post('type') == "shop") {
				if($this->input->post('shop')){
					$reviews = $this->db->get_where('service_review',['shop' => $this->input->post('shop')])->result_array();
					$reviewsList = [];
					foreach ($reviews as $key => $value) {
						$value['customer_ob']	= $this->customer_model->getCustomerData($value['customer']);
						array_push($reviewsList, $value);
					}
					retJson(['_return' => true,'data' => $reviewsList]);
				}else{
					retJson(['_return' => false,'msg' => '`shop` are Required']);		
				}				
			} else{
				retJson(['_return' => false,'msg' => 'not valid type']);		
			}

		}else{
			retJson(['_return' => false,'msg' => '`type`(customer,provider,shop) are Required']);
		}	
	}

	public function review_to_customer()
	{
		if($this->input->post('booking') && $this->input->post('public_note') && $this->input->post('private_note') && $this->input->post('cleanliness') && $this->input->post('communication') && $this->input->post('checkin') && $this->input->post('ob_shop_rules') && $this->input->post('serv_again')){
			$booking = $this->db->get_where('booking',['id' => $this->input->post('booking')])->row_array();
			if ($booking) {
				$data = [
					'customer'			=> $booking['user'],
					'provider'			=> $booking['provider'],
					'booking'			=> $booking['id'],
					'private_note'		=> $this->input->post('private_note'),
					'public_note'		=> $this->input->post('public_note'),
					'cleanliness'		=> $this->input->post('cleanliness'),
					'communication'		=> $this->input->post('communication'),
					'checkin'			=> $this->input->post('checkin'),
					'ob_shop_rules'		=> $this->input->post('ob_shop_rules'),
					'serv_again'		=> $this->input->post('serv_again'),
						'cat'		=> _nowDateTime()
				];	
				$this->db->insert('customer_review',$data);
				retJson(['_return' => true,'msg' => 'Review Added']);
			}else{
				retJson(['_return' => false,'msg' => 'Booking not found']);
			}
		}else{
			retJson(['_return' => false,'msg' => '`booking`,`public_note`,`private_note`,`cleanliness`,`communication`,`checkin`,`ob_shop_rules`,`serv_again` are Required(add rating value with decimal places like 0.00,1.00,1.02,1.20)']);
		}
	}

	public function review_to_service()
	{
		if($this->input->post('booking') && $this->input->post('shop') && $this->input->post('provider') && $this->input->post('service') && $this->input->post('note')){
			$booking = $this->db->get_where('booking',['id' => $this->input->post('booking')])->row_array();
			if ($booking) {
				$product = $this->db->get_where('booking_products',['booking' => $this->input->post('booking')])->row_array();
				$prodId = "";
				if ($product) {
					$prodId = $product['product'];
				}
				$data = [
					'customer'			=> $booking['user'],
					'provider'			=> $booking['provider'],
					'booking'			=> $booking['id'],
					'shop_id'			=> $booking['shop'],
					'product'			=> $prodId,
					'shop'				=> $this->input->post('shop'),
					'sprovider'			=> $this->input->post('provider'),
					'service'			=> $this->input->post('service'),
					'note'				=> $this->input->post('note'),
						'cat'		=> _nowDateTime()
				];	
				$this->db->insert('service_review',$data);
				$this->setShopRating($booking['shop']);
				$this->setProviderRating($booking['provider']);
				$this->setProductRating($prodId);
				retJson(['_return' => true,'msg' => 'Review Added']);
			}else{
				retJson(['_return' => false,'msg' => 'Booking not found']);
			}
		}else{
			retJson(['_return' => false,'msg' => '`booking`,`shop`,`provider`,`service`,`note` are Required(add rating value with decimal places like 0.00,1.00,1.02,1.20)']);
		}
	}

	public function setShopRating($shop)
	{
		$this->db->select_sum('shop');
		$this->db->where('shop_id',$shop);
		$this->db->from('service_review');
		$getTotalRating = $this->db->get()->row();
		$old = 0.00;
		if($getTotalRating){
			$old = $getTotalRating->shop;
		}
		$reviewCount = $this->db->get_where('service_review',['shop_id' => $shop])->num_rows();
		$newRating = ($old * 5) / ($reviewCount * 5);
		$this->db->where('id',$shop)->update('shop',['rating' => $newRating]);
	}

	public function setProviderRating($provider)
	{
		$this->db->select_sum('sprovider');
		$this->db->where('provider',$provider);
		$this->db->from('service_review');
		$getTotalRating = $this->db->get()->row();
		$old = 0.00;
		if($getTotalRating){
			$old = $getTotalRating->sprovider;
		}
		$reviewCount = $this->db->get_where('service_review',['provider' => $provider])->num_rows();
		$newRating = ($old * 5) / ($reviewCount * 5);
		$this->db->where('id',$provider)->update('service_provider',['rating' => $newRating]);
	}

	public function setProductRating($product)
	{
		if($product != ""){
			$this->db->select_sum('service');
			$this->db->where('product',$product);
			$this->db->from('service_review');
			$getTotalRating = $this->db->get()->row();
			$old = 0.00;
			if($getTotalRating){
				$old = $getTotalRating->service;
			}
			$reviewCount = $this->db->get_where('service_review',['product' => $product])->num_rows();
			$newRating = ($old * 5) / ($reviewCount * 5);
			$this->db->where('id',$product)->update('service_provider',['rating' => $newRating]);
		}
	}
}