<?php
class General extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_membership_plans()
	{
		if($this->input->post('time')){

			if ($this->input->post('time') == "monthly") {
				$plans = $this->db->get_where('packages')->result_array();
				foreach ($plans as $key => $value) {
					
				}			
				retJson(['_return' => true,'plans' => $plans]);	
			}else{
				$plans = $this->db->get_where('packages')->result_array();
				foreach ($plans as $key => $value) {
					$plans[$key]['price']	= $value['price'] * 12;
				}			
				retJson(['_return' => true,'plans' => $plans]);	
			}

		}else{
			retJson(['_return' => false,'msg' => '`time`(monthly,yearly) is Required']);	
		}	
	}

	public function get_settings()
	{
		$settingArray = [
			'_return' 					=> true,
			'prod_tax' 					=> get_setting()['prod_tax'],
			'serv_tax' 					=> get_setting()['serv_tax'],
			'stripe_sk' 				=> get_setting()['stripe_sk'],
			'stripe_pk' 				=> get_setting()['stripe_pk'],
			'customer_support_phone' 	=> get_setting()['customer_support_phone'],
			'shop_rule' 				=> get_setting()['shop_rule'],
			'msg'						=> '`usertype` is optional.,set `is_online`(no,yes) for offline online parameter'
		];
		if ($this->input->post('usertype')) {
			if ($this->input->post('user') && $this->input->post('token')) {
				if($this->input->post('usertype') == "service"){
					$isLoggedIn = $this->db->get_where('service_firebase',['user' => $this->input->post('user'),'token' => $this->input->post('token')])->row_array();
					if ($isLoggedIn) {
						$settingArray['serviceLoggedIn'] = "1";
					}else{
						$settingArray['serviceLoggedIn'] = "0";
					}

					if($this->input->post('is_online')){
						if($this->input->post('is_online') == "yes"){ $isOnline = 1; }else{ $isOnline = 0; }
						$this->db->where('id',$this->input->post('user'))->update('service_provider',['is_online' => $isOnline]);
					}	

				}else{
					$isLoggedIn = $this->db->get_where('customer_firebase',['user' => $this->input->post('user'),'token' => $this->input->post('token')])->row_array();
					if ($isLoggedIn) {
						$settingArray['serviceLoggedIn'] = "1";
					}else{
						$settingArray['serviceLoggedIn'] = "0";
					}
					if($this->input->post('is_online')){
						if($this->input->post('is_online') == "yes"){ $isOnline = 1; }else{ $isOnline = 0; }
						$this->db->where('id',$this->input->post('user'))->update('customer',['is_online' => $isOnline]);
					}
					$settingArray['cart'] = $this->db->get_where('booking_products',['booking' => '','user' => $this->input->post('user')])->num_rows();
				}
				retJson($settingArray);	
			}else{
				retJson(['_return' => false,'msg' => '`user` , `token` are Required']);
			}
		}else{
			retJson($settingArray);
		}
	}

	public function get_master_datas()
	{
		$categories = $this->db->get_where('categories',['df' => '','block' => ''])->result_array();
		foreach ($categories as $key => $value) {
			$categories[$key]['image']	= $this->general_model->getCategoryThumb($value['id']);
		}
		$occupations = $this->db->get_where('master_occupations',['df' => ''])->result_array();
		$skills = $this->db->get_where('master_skills',['df' => ''])->result_array();
		$sizes = $this->db->get_where('master_size',['df' => ''])->result_array();
		$brands = $this->db->get_where('master_brand',['df' => ''])->result_array();
		retJson(['_return' => true,'occupations' => $occupations,'skills' => $skills,'categories' => $categories,'sizes' => $sizes,'brands' => $brands]);		
	}

	public function page()
	{
		if($this->input->post('page')){
			if($this->input->post('page') == "terms"){
				$page = $this->db->get_where('pages',['id' => '1'])->row_array();
				retJson(['_return' => true,'page' => $page]);		
			}else if($this->input->post('page') == "help"){
				$page = $this->db->get_where('pages',['id' => '2'])->row_array();
				retJson(['_return' => true,'page' => $page]);		
			}else if($this->input->post('page') == "about_groom"){
				$page = $this->db->get_where('pages',['id' => '3'])->row_array();
				retJson(['_return' => true,'page' => $page]);		
			}else if($this->input->post('page') == "sharing"){
				$page = $this->db->get_where('pages',['id' => '4'])->row_array();
				retJson(['_return' => true,'page' => $page]);		
			}else if($this->input->post('page') == "datause"){
				$page = $this->db->get_where('pages',['id' => '5'])->row_array();
				retJson(['_return' => true,'page' => $page]);		
			}else{
				retJson(['_return' => false,'msg' => 'Please Enter Valid Page name']);		
			}
		}else{
			retJson(['_return' => false,'msg' => '`page`(terms,help,about_groom,sharing,datause) is Required']);	
		}
	}

	public function getcategories()
	{
		$categories = $this->db->get_where('categories',['df' => '','block' => ''])->result_array();
		foreach ($categories as $key => $value) {
			$categories[$key]['image']	= $this->general_model->getCategoryThumb($value['id']);
		}
		retJson(['_return' => true,'count' => count($categories),'list' => $categories]);		
	}

	public function verify_otp()
	{
		if($this->input->post('user') && $this->input->post('usertype') && $this->input->post('otp') && $this->input->post('otptype')){
			if($this->input->post('otptype') == 'login'){
				if($this->input->post('firebase_token') && $this->input->post('device') && $this->input->post('device_id')){
					$otp = $this->db->get_where('z_otp',['user' => $this->input->post('user'),'otp' => $this->input->post('otp'),'otptype' => $this->input->post('otptype'),'usertype' => $this->input->post('usertype'),'used' => '0'])->row_array();
					if($otp){
						$this->db->where('user',$this->input->post('user'))->where('otptype','login')->where('usertype','service')->update('z_otp',['used' => '1']);
						if($this->input->post('usertype') == 'service'){
							$firebase = [
								'desc'		=> $this->input->post('desc'),
								'token'		=> $this->input->post('firebase_token'),
								'device'	=> $this->input->post('device'),
								'device_id'	=> $this->input->post('device_id'),
								'user'		=> $this->input->post('user'),
								'cat'		=> _nowDateTime()
							];
							$this->db->insert('service_firebase',$firebase);
							retJson(['_return' => true,'msg' => 'Login Success','data' => $this->service_model->getServiceData($this->input->post('user'))]);
						}else{
							$firebase = [
								'desc'		=> $this->input->post('desc'),
								'token'		=> $this->input->post('firebase_token'),
								'device'	=> $this->input->post('device'),
								'device_id'	=> $this->input->post('device_id'),
								'user'		=> $this->input->post('user'),
								'cat'		=> _nowDateTime()
							];
							$this->db->insert('customer_firebase',$firebase);
							retJson(['_return' => true,'msg' => 'Login Success','data' => $this->customer_model->getCustomerData($this->input->post('user'))]);
						}
					}else{
						retJson(['_return' => false,'msg' => 'OTP Not Valid']);		
					}
				}else{
					retJson(['_return' => false,'msg' => '`device`,`device_id` and `firebase_token` are Required']);	
				}
			}
			else if ($this->input->post('otptype') == 'register') {
				if($this->input->post('usertype') == 'service'){
					if($this->input->post('user') && $this->input->post('otp')){
						$otp = $this->db->get_where('z_otp',['user' => $this->input->post('user'),'otp' => $this->input->post('otp'),'otptype' => 'register_phone','usertype' => 'service','used' => '0'])->row_array();
						if($otp){
							if($this->input->post('fname') && $this->input->post('lname') && $this->input->post('phone') && $this->input->post('desc') && isset($_FILES ['profileimg'])){
								$config['upload_path'] = './uploads/service/';
							    $config['allowed_types']	= '*';
							    $config['max_size']      = '0';
							    $config['overwrite']     = TRUE;
							    $this->load->library('upload', $config);
							    if(isset($_FILES ['profileimg']) && $_FILES['profileimg']['error'] == 0){
							    	$config['file_name'] = microtime(true).".".pathinfo($_FILES['profileimg']['name'], PATHINFO_EXTENSION);
							    	$this->upload->initialize($config);
							    	if($this->upload->do_upload('profileimg')){
							    		$profileFileName = $config['file_name'];
							    	}else{
							    		$profileFileName = "";
							    	}
							    }else{
						    		$profileFileName = "";
						    	}
						    	$businessName = "";
								if ($this->input->post('business')) {
									$businessName = $this->input->post('business');
								}
								$servicesAr = "";
								if ($this->input->post('services')) {
									$servicesAr = $this->input->post('services');
								}
								$data = [
									'firstname'		=> $this->input->post('fname'),
									'lastname'		=> $this->input->post('lname'),
									'business'		=> $businessName,
									'services'		=> $servicesAr,
									'descr'			=> $this->input->post('desc'),
									'profile_pic'	=> $profileFileName,
									'verified'		=> '1',
									'cat'			=> _nowDateTime()
								];
								$this->db->where('id',$this->input->post('user'))->update('service_provider',$data);
								$this->db->where('user',$this->input->post('user'))->where('otptype','register_phone')->where('usertype','service')->update('z_otp',['used' => '1']);
								retJson(['_return' => true,'msg' => 'Sign Up Successful.']);
							}else{
								retJson(['_return' => false,'msg' => '`fname`,`lname`,`phone`,`profileimg` and `desc` are Required,`business`,`services` is optional']);	
							}
						}else{
							retJson(['_return' => false,'msg' => 'OTP Not Valid']);		
						}
					}else{
						retJson(['_return' => false,'msg' => '`user`(user_id) and `otp` is Required']);	
					}	
				}else{
					if($this->input->post('user') && $this->input->post('otp')){
						$otp = $this->db->get_where('z_otp',['user' => $this->input->post('user'),'otp' => $this->input->post('otp'),'otptype' => 'register_phone','usertype' => 'customer','used' => '0'])->row_array();
						if($otp){
							if($this->input->post('fname') && $this->input->post('lname')){
								$config['upload_path'] = './uploads/service/';
							    $config['allowed_types']	= '*';
							    $config['max_size']      = '0';
							    $config['overwrite']     = TRUE;
							    $this->load->library('upload', $config);
								if(isset($_FILES ['profileimg']) && $_FILES['profileimg']['error'] == 0){
							    	$config['file_name'] = microtime(true).".".pathinfo($_FILES['profileimg']['name'], PATHINFO_EXTENSION);
							    	$this->upload->initialize($config);
							    	if($this->upload->do_upload('profileimg')){
							    		$profileFileName = $config['file_name'];
							    	}else{
							    		$profileFileName = "";
							    	}
							    }else{
						    		$profileFileName = "";
						    	}
								$data = [
									'profile_pic'	=> $profileFileName,
									'firstname'	=> $this->input->post('fname'),
									'lastname'	=> $this->input->post('lname'),
									'verified'	=> '1',
									'ver_phone'	=> '1',
									'cat'		=> _nowDateTime()
								];
								$this->db->where('id',$this->input->post('user'))->update('customer',$data);
								$this->db->where('user',$this->input->post('user'))->where('otptype','register_phone')->where('usertype','customer')->update('z_otp',['used' => '1']);
								retJson(['_return' => true,'msg' => 'Sign Up Successful.']);
							}else{
								retJson(['_return' => false,'msg' => '`fname` and `lname` is Required']);		
							}
						}else{
							retJson(['_return' => false,'msg' => 'OTP Not Valid']);		
						}
					}else{
						retJson(['_return' => false,'msg' => '`user`(user_id) and `otp` is Required']);	
					}
				}
			}
		}else{
			retJson(['_return' => false,'msg' => '`otptype` (register,login),`user` (User id),`usertype` (customer,service) and `otp` are Required']);
		}
	}
}