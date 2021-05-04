<?php
class Others extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function check_gift_card()
	{
		if($this->input->post('user') && $this->input->post('gift_card')){
			$customer = $this->customer_model->getCustomerData($this->input->post('user'));
			$checkCard = $this->db->get_where('gift_card',['card_id' => $this->input->post('gift_card'),'used' => '0','email' => $customer['email']])->row_array();
			if ($checkCard) {
				retJson(['_return' => true,'msg' => 'Gift Card is valid']);	
			}else{
				retJson(['_return' => false,'msg' => 'Gift Card is not valid']);	
			}
		}else{
			retJson(['_return' => false,'msg' => '`user`,`gift_card` are Required']);
		}
	}

	public function send_gift_card()
	{
		if($this->input->post('user') && $this->input->post('email') && $this->input->post('amount') && $this->input->post('card_id')){
			$customer = $this->customer_model->getCustomerData($this->input->post('user'));
			if($customer){
				if($customer['stripeclient'] != '' && $customer['stripeclient'] != NULL){

					$chargeClient = $this->stripelib->chargeClient(
						$this->input->post('amount'),
						$customer['stripeclient'],
						$this->input->post('card_id')
					);

					if($chargeClient){

						$data = [	
							'card_id'	=> getGiftCardId(),
							'customer'	=> $this->input->post('user'),
							'email'		=> $this->input->post('email'),
							'amount'	=> $this->input->post('amount'),
							'card'		=> $this->input->post('card_id'),
							'cat'		=> _nowDateTime()
						];

						$this->db->insert('gift_card',$data);
						retJson(['_return' => true,'msg' => "Gift Card Sent"]);	
						
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
			retJson(['_return' => false,'msg' => '`user`,`email`,`amount`,`card_id` are Required']);
		}	
	}

	public function get_notifications()
	{
		if($this->input->post('user') && $this->input->post('user_type')){
			$this->db->limit(100);
			$this->db->order_by('id','desc');
			$this->db->where('user',$this->input->post('user'));
			$this->db->where('user_type',$this->input->post('user_type'));
			$notifications = $this->db->get('notifications')->result_array();

			retJson(['_return' => true,'list' => $notifications]);						

		}else{
			retJson(['_return' => false,'msg' => '`user`,`user_type`(customer,provider) is Required']);
		}	
	}

	public function customer_reminder()
	{
		if($this->input->post('booking') && $this->input->post('desc')){
			$booking = $this->booking_model->getServiceBooking($this->input->post('booking'));
			$customer = $booking['user'];
			$this->other_model->saveNotification(
				$this->input->post('booking'),
				'booking',
				$customer['id'],
				'customer',
				'Reminder For Booking',
				$this->input->post('desc')
			);

			$this->general_model->customerPush(
				$customer['id'],
				'Reminder For Booking',
				$this->input->post('desc')	
			);

			retJson(['_return' => true,'msg' => 'Reminder Sent']);
		}else{
			retJson(['_return' => false,'msg' => '`booking`,`desc` is Required']);
		}		
	}



	//Favorite Products or Service
	public function get_folders()
	{
		if($this->input->post('user')){
			retJson(['_return' => true,'list' => $this->general_model->getFavFolders($this->input->post('user'))]);
		}else{
			retJson(['_return' => false,'msg' => '`user` is Required']);
		}		
	}

	public function delete_fav_prod()
	{
		if($this->input->post('product') && $this->input->post('user')){
			$this->db->where('user',$this->input->post('user'))->where('product',$this->input->post('product'))->delete('others_favourite_products');
			retJson(['_return' => true,'msg' => 'Product deleted from folder.']);
		}else{
			retJson(['_return' => false,'msg' => '`product`,`user` are Required']);
		}
	}

	public function get_fav_prods()
	{
		if($this->input->post('folder')){
			$this->db->where('folder',$this->input->post('folder'));
			$list = $this->db->get('others_favourite_products')->result_array();
			$prods = [];
			foreach ($list as $key => $value) {
				$prod = $this->shop_model->getProduct($value['product']);
				if($this->input->post('user')){
					$cart = $this->db->get_where('booking_products',['user' => $this->input->post('user'),'product' => $value['product'],'booking' => ''])->row_array();
					$prod['cart'] = $cart;
				}
				if($prod['df'] == ''){
					array_push($prods, $prod);
				}
				
			}
			retJson(['_return' => true,'list' => $prods]);
		}else{
			retJson(['_return' => false,'msg' => '`folder` is Required,`user` is optional']);
		}	
	}

	public function add_fav_prod()
	{
		if($this->input->post('user') && $this->input->post('folder') && $this->input->post('product')){
			$data = [
				'folder'		=> $this->input->post('folder'),
				'user'			=> $this->input->post('user'),
				'product'		=> $this->input->post('product'),
				'cat'			=> _nowDateTime()
			];
			$this->db->insert('others_favourite_products',$data);
			retJson(['_return' => true,'msg' => 'Product added to favourite.']);
		}else{
			retJson(['_return' => false,'msg' => '`user`,`folder` and `product` are Required']);
		}
	}

	public function modify_fav_folder()
	{
		if($this->input->post('type')){
			if($this->input->post('type') == "edit"){
				if($this->input->post('folder') && $this->input->post('user') && $this->input->post('title')){
					$this->db->where('id',$this->input->post('folder'))->update('others_favourite_folders',['title' => $this->input->post('title')]);
					retJson(['_return' => true,'msg' => 'Folder Saved.','list' => $this->general_model->getFavFolders($this->input->post('user'))]);
				}else{
					retJson(['_return' => false,'msg' => '`folder`,`title` and `user` are Required']);		
				}
			}else if($this->input->post('type') == "delete"){
				if($this->input->post('folder') && $this->input->post('user')){
					$this->db->where('folder',$this->input->post('folder'))->delete('others_favourite_products');
					$this->db->where('id',$this->input->post('folder'))->delete('others_favourite_folders');
					retJson(['_return' => true,'msg' => 'Folder Deleted.','list' => $this->general_model->getFavFolders($this->input->post('user'))]);
				}else{
					retJson(['_return' => false,'msg' => '`folder` and `user` are Required']);		
				}
			}else{
				retJson(['_return' => false,'msg' => 'not valid type']);	
			}
		}else{
			retJson(['_return' => false,'msg' => '`type`(edit,delete) is Required']);
		}
	}

	public function create_favourite_folder()
	{
		if($this->input->post('user') && $this->input->post('title')){
			$data = [
				'title'		=> $this->input->post('title'),
				'user'		=> $this->input->post('user'),
				'cat'		=> _nowDateTime()
			];
			$this->db->insert('others_favourite_folders',$data);
			retJson(['_return' => true,'msg' => 'Folder Created.','list' => $this->general_model->getFavFolders($this->input->post('user'))]);
		}else{
			retJson(['_return' => false,'msg' => '`user` and `title` are Required']);
		}
	}
}