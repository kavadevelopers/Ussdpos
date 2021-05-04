<?php
class Chat extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_chat_account_for_provider()
	{
		if ($this->input->post('user')) {
			$bookings = $this->db->get_where('booking',['provider' => $this->input->post('user')])->result_array();

			$chatList = [];
			foreach ($bookings as $key => $value) {
				$this->db->order_by('id','desc');
				$this->db->where('chat_type','booking');
				$this->db->where('type','message');
				$this->db->where('main',$value['id']);
				$lastChat = $this->db->get('chat')->row_array();
				if($lastChat){
					$chat['booking']			= $value['id'];
					$chat['provider']			= $this->service_model->getServiceData($value['provider']);
					$chat['customer']			= $this->customer_model->getCustomerData($value['user']);
					$chat['last_msg']			= $lastChat;
					$chat['unread_count']		= $this->db->get_where('chat',['main' => $value['id'],'ftype' => 'customer','readed' => '0'])->num_rows();
					array_push($chatList, $chat);
				}
			}

			// $keys = array_column($chatList, 'unread_count');
			// array_multisort($keys, SORT_DESC, $chatList);
			retJson(['_return' => true,'list' => $chatList]);		
		}else{
			retJson(['_return' => false,'msg' => '`user` are Required']);		
		}
	}

	public function get_chat_account_for_customer()
	{
		if ($this->input->post('user')) {
			$bookings = $this->db->get_where('booking',['user' => $this->input->post('user'),'provider !=' => NULL])->result_array();

			$chatList = [];
			foreach ($bookings as $key => $value) {
				$this->db->order_by('id','desc');
				$this->db->where('chat_type','booking');
				$this->db->where('type','message');
				$this->db->where('main',$value['id']);
				$lastChat = $this->db->get('chat')->row_array();
				if($lastChat){
					$chat['booking']			= $value['id'];
					$chat['provider']			= $this->service_model->getServiceData($value['provider']);
					$chat['customer']			= $this->customer_model->getCustomerData($value['user']);
					$chat['last_msg']			= $lastChat;
					$chat['unread_count']		= $this->db->get_where('chat',['main' => $value['id'],'ftype' => 'provider','readed' => '0'])->num_rows();
					array_push($chatList, $chat);
				}
			}

			// $keys = array_column($chatList, 'unread_count');
			// array_multisort($keys, SORT_DESC, $chatList);
			retJson(['_return' => true,'list' => $chatList]);		
		}else{
			retJson(['_return' => false,'msg' => '`user` are Required']);		
		}
	}

	public function get_new_messages()
	{
		if($this->input->post('booking') && $this->input->post('last') && $this->input->post('user') && $this->input->post('user_type')){
			$booking = $this->db->get_where('booking',['id' => $this->input->post('booking')])->row_array();
			if($booking){
				$this->db->order_by('id','asc');
				$this->db->where('chat_type','booking');
				$this->db->where('id >',$this->input->post('last'));
				$this->db->where('main'	,$this->input->post('booking'));
				if ($this->input->post('user_type') == "customer") {
					$this->db->where('ftype'	,"provider");
				}else{
					$this->db->where('ftype'	,"customer");
				}
				$this->db->where('t',$this->input->post('user'));
				$chats = $this->db->get('chat')->result_array();
				$list = [];
        		$last = $this->input->post('last');
        		foreach ($chats as $key => $chat) {
        			array_push($list, $this->chat_model->getChat($chat['id']));
        			$last = $chat['id'];
        		}
        		foreach ($chats as $key => $chat) {
        			if($chat['t'] == $this->input->post('user')){
        				$this->db->where('id',$chat['id'])
        					->update('chat',['readed' => '1']);
        			}
        		}
        		retJson(['_return' => true,'last' => $last,'list' => $list]);		
			}else{
				retJson(['_return' => false,'msg' => '`booking` not found']);		
			}
		}else{
			retJson(['_return' => false,'msg' => '`booking`,`last`,`user`,`user_type`(customer,provider) are Required']);	
		}	
	}

	public function get_messages()
	{
		if($this->input->post('booking') && $this->input->post('user')){
			$booking = $this->db->get_where('booking',['id' => $this->input->post('booking')])->row_array();
			if($booking){
				$this->db->select('id,f,t');
				$this->db->order_by('id','asc');
				$this->db->where('chat_type','booking');
				$this->db->where('main'	,$this->input->post('booking'));
				$this->db->where_in('f',[$booking['user'],$booking['provider']]);
				$this->db->where_in('t',[$booking['user'],$booking['provider']]);
				$chats = $this->db->get('chat')->result_array();
				$list = [];
        		$last = '0';
        		foreach ($chats as $key => $chat) {
        			array_push($list, $this->chat_model->getChat($chat['id']));
        			$last = $chat['id'];
        		}

        		// read chat code
        		foreach ($chats as $key => $chat) {
        			if($chat['t'] == $this->input->post('user')){
        				$this->db->where('id',$chat['id'])
        					->update('chat',['readed' => '1']);
        			}
        		}


        		retJson(['_return' => true,'last' => $last,'list' => $list]);		
			}else{
				retJson(['_return' => false,'msg' => '`booking` not found']);		
			}
		}else{
			retJson(['_return' => false,'msg' => '`booking`,`user` are Required']);	
		}		
	}

	public function get_single()
	{
		if($this->input->post('chat')){
			retJson(['_return' => true,'data' => $this->chat_model->getChat($this->input->post('chat'))]);			
		}else{
			retJson(['_return' => false,'msg' => '`chat` are Required']);	
		}	
	}

	public function send()
	{
		if($this->input->post('booking') && $this->input->post('from') && $this->input->post('to') && $this->input->post('from_type') && $this->input->post('type')){
			if($this->input->post('type') == "message"){
				if($this->input->post('message')){
					$message = $this->input->post('message');
				}else{
					retJson(['_return' => false,'msg' => '`message` are Required']);	
					exit;		
				}
			}else if($this->input->post('type') == "image"){
				if($this->input->post('image')){
					$img = str_replace('data:image/png;base64,', '', $this->input->post('image'));
					$img = str_replace(' ', '+', $img);
					$data = base64_decode($img);
					$file = microtime(true).'.png';
					file_put_contents('./uploads/chat/'.$file, $data);
					$message = $file;
				}else{
					retJson(['_return' => false,'msg' => '`image` are Required']);	
					exit;		
				}
			}else{
				retJson(['_return' => false,'msg' => 'Not Allowed']);	
				exit;	
			}

			$data = [
				'main'				=> $this->input->post('booking'),
				'f'					=> $this->input->post('from'),
				't'					=> $this->input->post('to'),
				'ftype'				=> $this->input->post('from_type'),
				'type'				=> $this->input->post('type'),
				'chat_type'			=> "booking",
				'descr'				=> $message,
				'cat'				=> _nowDateTime()
			];
			$this->db->insert('chat',$data);
			$chat = $this->db->insert_id();
			$list = [];
			array_push($list, $this->chat_model->getChat($chat));

			if ($this->input->post('from_type') == "customer") {
				$customer = $this->customer_model->getCustomerData($this->input->post('from'));
				$this->general_model->servicePush(
					$this->input->post('to'),
					'New Message',
					"New Message From customer",
					"chat",
					['booking' => $this->input->post('booking'),'user' => $this->input->post('to'),'name' => $customer['firstname'].' '.$customer['lastname']]	
				);
			}else{
				$service = $this->service_model->getServiceData($this->input->post('from'));
				$this->general_model->customerPush(
					$this->input->post('to'),
					'New Message',
					"New Message From provider",
					"chat",
					['booking' => $this->input->post('booking'),'user' => $this->input->post('to'),'name' => $service['firstname'].' '.$service['lastname']]	
				);
			}


			retJson(['_return' => true,'msg' => 'Message Sent','list' => $list]);
		}else{
			retJson(['_return' => false,'msg' => '`from`,`to`,`from_type`(customer,provider),`type`(image,message),`booking` are Required']);
		}
	}

}