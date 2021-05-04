<?php
class Authservice extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function save_time()
	{
		if($this->input->post('service')){
			$service = $this->db->get_where('service_timing',['service' => $this->input->post('service')])->row_array();
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

			if ($service) {
				$this->db->where('service',$this->input->post('service'))->update('service_timing',$data);
			}else{
				$data['service']	= $this->input->post('service');
				$this->db->insert('service_timing',$data);
			}

			retJson(['_return' => true,'msg' => 'Timing Updated']);
		}else{
			retJson(['_return' => false,'msg' => '`service` is Required,Optional parameters are `monday_from`,`monday_to`,`tuesday_from`,`tuesday_to`,`wednesday_from`,`wednesday_to`,`thursday_from`,`thursday_to`,`friday_from`,`friday_to`,`saturday_from`,`saturday_to`,`sunday_from`,`sunday_to`']);
		}
	}

	public function edit_user()
	{
		if($this->input->post('user') && $this->input->post('fname') && $this->input->post('lname') && $this->input->post('phone') && $this->input->post('services') && $this->input->post('desc') && $this->input->post('ccode') && $this->input->post('user_type')){

			$data = [
				'utype'			=> $this->input->post('user_type'),
				'firstname'		=> $this->input->post('fname'),
				'lastname'		=> $this->input->post('lname'),
				'ccode'			=> $this->input->post('ccode'),
				'phone'			=> $this->input->post('phone'),
				'services'		=> $this->input->post('services'),
				'descr'			=> $this->input->post('desc')
			];
			$this->db->where('id',$this->input->post('user'))->update('service_provider',$data);

			if ($this->input->post('password')) {
				$this->db->where('id',$this->input->post('user'))->update('service_provider',['password' => md5($this->input->post('password'))]);				
			}

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
		    		$this->db->where('id',$this->input->post('user'))->update('service_provider',['profile_pic' => $profileFileName]);		
		    	}
		    }
		    retJson(['_return' => true,'msg' => "User Updated"]);
		}else{
			retJson(['_return' => false,'msg' => '`user`,`fname`,`lname`,`phone`,`ccode`,`services`,`desc`,`user_type`(manager,provider) are Required,`profileimg`,`password` is Optional']);	
		}
	}

	public function delete_user()
	{
		if ($this->input->post('user')) {
			$this->db->where('id',$this->input->post('user'))->update('service_provider',['df' => 'yes']);
			retJson(['_return' => true,'msg' => "User Deleted"]);
		}else{
			retJson(['_return' => false,'msg' => '`user` are Required']);	
		}	
	}

	public function get_child_users()
	{
		if ($this->input->post('parent') && $this->input->post('shop')) {
			if ($this->input->post('type')) {
				$users = $this->db->get_where('service_provider',['utype' => $this->input->post('type'),'service' => $this->input->post('parent'),'shop' => $this->input->post('shop'),'df' => ''])->result_array();
				$childs = [];
				foreach ($users as $key => $value) {
					$user = $this->service_model->getServiceData($value['id']);
					array_push($childs, $user);
				}
			}else{
				$users = $this->db->get_where('service_provider',['id' => $this->input->post('parent')])->result_array();
				$childs = [];
				foreach ($users as $key => $value) {
					$user = $this->service_model->getServiceData($value['id']);
					array_push($childs, $user);
				}
				$users = $this->db->order_by('utype','asc')->get_where('service_provider',['service' => $this->input->post('parent'),'shop' => $this->input->post('shop'),'df' => ''])->result_array();
				
				foreach ($users as $key => $value) {
					$user = $this->service_model->getServiceData($value['id']);
					array_push($childs, $user);
				}
			}
			retJson(['_return' => true,'list' => $childs]);
		}else{
			retJson(['_return' => false,'msg' => '`parent`,`shop` are Required,`type`(manager,provider) is Optional']);	
		}
	}

	public function create_user()
	{
		if($this->input->post('fname') && $this->input->post('lname') && $this->input->post('email') && $this->input->post('password') && $this->input->post('phone') && $this->input->post('services') && $this->input->post('desc') && $this->input->post('ccode') && $this->input->post('parent') && $this->input->post('user_type') && $this->input->post('shop')){
			$old = $this->db->get_where('service_provider',['rtype' => 'email','email' => $this->input->post('email'),'df' => '']);
			$oldp = $this->db->get_where('service_provider',['rtype' => 'email','phone' => $this->input->post('phone'),'ccode' => $this->input->post('ccode'),'df' => '']);
			if($old->num_rows() == 0){
				if($oldp->num_rows() == 0){
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

			    	$parent = $this->service_model->getServiceData($this->input->post('parent'));

			    	$data = [
						'utype'			=> $this->input->post('user_type'),
						'rtype'			=> 'email',
						'shop'			=> $this->input->post('shop'),
						'firstname'		=> $this->input->post('fname'),
						'lastname'		=> $this->input->post('lname'),
						'email'			=> $this->input->post('email'),
						'ccode'			=> $this->input->post('ccode'),
						'phone'			=> $this->input->post('phone'),
						'business'		=> $parent['business'],
						'services'		=> $this->input->post('services'),
						'descr'			=> $this->input->post('desc'),
						'service'		=> $this->input->post('parent'),
						'password'		=> md5($this->input->post('password')),
						'profile_pic'	=> $profileFileName,
						'verified'		=> '1',
						'ref_code'		=> getProviderCode(),
						'cat'			=> _nowDateTime()
					];
					$this->db->insert('service_provider',$data);
					$providerId = $this->db->insert_id();
					
					$old = $this->db->get_where('customer',['rtype' => 'email','email' => $this->input->post('email'),'df' => '']);
					if($old->num_rows() > 0){
						$this->db->where('id',$old->row_array()['id'])->update('customer',['utype' => 'provider','provider_id' => $providerId]);
						$this->db->where('id',$providerId)->update('service_provider',['customer' => $old->row_array()['id']]);
					}else{
						$data = [
							'utype'			=> 'provider',
							'rtype'			=> 'email',
							'firstname'		=> $this->input->post('fname'),
							'lastname'		=> $this->input->post('lname'),
							'email'			=> $this->input->post('email'),
							'ccode'			=> $this->input->post('ccode'),
							'phone'			=> $this->input->post('phone'),
							'password'		=> md5($this->input->post('password')),
							'profile_pic'	=> $profileFileName,
							'verified'		=> '1',
							'provider_id'	=> $providerId,
							'cat'			=> _nowDateTime()
						];
						$this->db->insert('customer',$data);
						$customerId = $this->db->insert_id();
						$this->db->where('id',$providerId)->update('service_provider',['customer' => $customerId]);
					}


					retJson(['_return' => true,'msg' => 'User Created']);
				}else{
					retJson(['_return' => false,'msg' => 'Phone Already Exists.']);	
				}
			}else{
				retJson(['_return' => false,'msg' => 'Email Already Exists.']);
			}
		}else{
			retJson(['_return' => false,'msg' => '`fname`,`lname`,`email`,`phone`,`ccode`,`services`,`desc`,`parent`,`user_type`(manager,provider),`shop` and `password` are Required,`profileimg` is Optional']);	
		}
	}

	public function purchase_package()
	{
		if($this->input->post('user') && $this->input->post('txt_id') && $this->input->post('package') && $this->input->post('amount') && $this->input->post('discount') && $this->input->post('time_in_month')){
			$data = [
				'user'			=> $this->input->post('user'),
				'txt_id'		=> $this->input->post('txt_id'),
				'package'		=> $this->input->post('package'),
				'amount'		=> $this->input->post('amount'),
				'discount'		=> $this->input->post('discount'),
				'time_in_month'	=> $this->input->post('time_in_month'),
				'expired_on'	=> plusMonth($this->input->post('time_in_month'),date('Y-m-d')),
				'purchased_on'	=> date('Y-m-d'),
				'cat'			=> _nowDateTime()
			];
			$this->db->insert('package_purchased',$data);
			$this->db->where('id',$this->input->post('user'))->update('service_provider',
				[
					'package_expired_on' 	=> plusMonth($this->input->post('time_in_month'),date('Y-m-d')),
					'package' 				=> $this->input->post('package')
				]
			);
			retJson(['_return' => true,'msg' => 'Package Purchased']);		
		}else{
			retJson(['_return' => false,'msg' => '`user`,`txt_id`,`package`,`amount`,`discount`,`time_in_month` are Required']);
		}	
	}

	public function change_dp()
	{
		if($this->input->post('user')){
			$user = $this->db->get_where('service_provider',['id' => $this->input->post('user')])->row_array();
			if($user){
				$config['upload_path'] = './uploads/service/';
			    $config['allowed_types']	= '*';
			    $config['max_size']      = '0';
			    $config['overwrite']     = TRUE;
			    $this->load->library('upload', $config);
			    if(isset($_FILES ['profileimg']) && $_FILES['profileimg']['error'] == 0){
			    	$config['file_name'] = microtime(true).".".pathinfo($_FILES['profileimg']['name'], PATHINFO_EXTENSION);
			    	$this->upload->initialize($config);
			    	if($this->upload->do_upload('profileimg')){
			    		$this->db->where('id',$this->input->post('user'))->update('service_provider',['profile_pic' => $config['file_name']]);
			    		retJson(['_return' => true,'msg' => 'Profile Image changed.','data' => $this->service_model->getServiceData($this->input->post('user'))]);
			    	}else{
			    		retJson(['_return' => false,'msg' => 'error in image upload']);
			    	}
			    }else{
		    		retJson(['_return' => false,'msg' => 'profileimg is required']);
		    	}
			}else{
				retJson(['_return' => false,'msg' => 'user not found']);
			}
		}else{
			retJson(['_return' => false,'msg' => '`user` is Required']);
		}
	}

	public function save_personalinfo()
	{	
		if($this->input->post('user') && $this->input->post('type')){
			if ($this->input->post('type') == "legal_name") {
				if($this->input->post('fname') && $this->input->post('lname')){
					$this->db->where('id',$this->input->post('user'))->update('service_provider',['firstname' => $this->input->post('fname'),'lastname' => $this->input->post('lname')]);
					retJson(['_return' => true,'msg' => 'Legal Name saved.']);	
				}else{
					retJson(['_return' => false,'msg' => '`fname` and `lname` are Required']);
				}
			}

			else if ($this->input->post('type') == "email") {
				if($this->input->post('email')){
					$user = $this->db->get_where('service_provider',['id' => $this->input->post('user')])->row_array();
					if($user['rtype'] == "email"){
						$old = $this->db->get_where('service_provider',['rtype' => 'email','email' => $this->input->post('email')])->row_array();
						if(!$old){
							$this->db->where('id',$this->input->post('user'))->update('service_provider',['email' => $this->input->post('email')]);
							retJson(['_return' => true,'msg' => 'Email saved.']);	
						}else{
							retJson(['_return' => false,'msg' => 'Email Address is Already exists.']);		
						}
					}else{
						$this->db->where('id',$this->input->post('user'))->update('service_provider',['email' => $this->input->post('email')]);
						retJson(['_return' => true,'msg' => 'Email saved.']);	
					}
				}else{
					retJson(['_return' => false,'msg' => '`email` is Required']);
				}	
			}

			else if ($this->input->post('type') == "phone") {
				if($this->input->post('phone') && $this->input->post('ccode')){
					$user = $this->db->get_where('service_provider',['id' => $this->input->post('user')])->row_array();
					if($user['rtype'] == "phone"){
						$old = $this->db->get_where('service_provider',['rtype' => 'phone','ccode' => $this->input->post('ccode'),'phone' => $this->input->post('phone')])->row_array();
						if(!$old){
							$this->db->where('id',$this->input->post('user'))->update('service_provider',['ccode' => $this->input->post('ccode'),'phone' => $this->input->post('phone')]);
							retJson(['_return' => true,'msg' => 'Phone saved.']);		
						}else{
							retJson(['_return' => false,'msg' => 'Phone no. is Already exists.']);		
						}
					}else{
						$this->db->where('id',$this->input->post('user'))->update('service_provider',['ccode' => $this->input->post('ccode'),'phone' => $this->input->post('phone')]);
						retJson(['_return' => true,'msg' => 'Phone saved.']);	
					}
				}else{
					retJson(['_return' => false,'msg' => '`phone` and `ccode`(Country Code) is Required']);
				}	
			}

			else if($this->input->post('type') == "gender"){
				if($this->input->post('gender')){
					$this->general_model->insertServiceDetails($this->input->post('user'));
					$this->db->where('user',$this->input->post('user'))->update('service_provider_details',['gender' => $this->input->post('gender')]);
					retJson(['_return' => true,'msg' => 'Gender saved.']);
				}else{
					retJson(['_return' => false,'msg' => '`gender` is Required']);
				}
			}

			else if($this->input->post('type') == "dob"){
				if($this->input->post('dob')){
					$this->general_model->insertServiceDetails($this->input->post('user'));
					$this->db->where('user',$this->input->post('user'))->update('service_provider_details',['dob' => dd($this->input->post('dob'))]);
					retJson(['_return' => true,'msg' => 'DOB saved.']);
				}else{
					retJson(['_return' => false,'msg' => '`dob` is Required']);
				}
			}

			else if($this->input->post('type') == "goverment"){
				if($this->input->post('goverment')){
					$this->general_model->insertServiceDetails($this->input->post('user'));
					$this->db->where('user',$this->input->post('user'))->update('service_provider_details',['goverment' => $this->input->post('goverment')]);
					retJson(['_return' => true,'msg' => 'Goverment Id saved.']);
				}else{
					retJson(['_return' => false,'msg' => '`goverment` is Required']);
				}
			}

			else if($this->input->post('type') == "address"){
				if($this->input->post('address')){
					$this->general_model->insertServiceDetails($this->input->post('user'));
					$this->db->where('user',$this->input->post('user'))->update('service_provider_details',['address' => $this->input->post('address')]);
					retJson(['_return' => true,'msg' => 'Address saved.']);
				}else{
					retJson(['_return' => false,'msg' => '`address` is Required']);
				}
			}

			else if($this->input->post('type') == "emergency_contact"){
				if($this->input->post('emergency_contact')){
					$this->general_model->insertServiceDetails($this->input->post('user'));
					$this->db->where('user',$this->input->post('user'))->update('service_provider_details',['emergency_contact' => $this->input->post('emergency_contact')]);
					retJson(['_return' => true,'msg' => 'Emergency Contact saved.']);
				}else{
					retJson(['_return' => false,'msg' => '`emergency_contact` is Required']);
				}
			}

			else{
				retJson(['_return' => false,'msg' => 'Type not found']);
			}
		}else{
			retJson(['_return' => false,'msg' => '`user` and `type`(legal_name,gender,dob,goverment,email,phone,address,emergency_contact) are Required']);
		}
	}

	public function change_password()
	{
		if($this->input->post('oldpassword') && $this->input->post('newpassword') && $this->input->post('user')){
			$user = $this->db->get_where('service_provider',['id' => $this->input->post('user')])->row_array();
			if($user){
				if($user['password'] == md5($this->input->post('oldpassword'))){
					$this->db->where('id',$this->input->post('user'))->update('service_provider',['password' => md5($this->input->post('newpassword'))]);
					retJson(['_return' => true,'msg' => 'Password changed.']);		
				}else{
					retJson(['_return' => false,'msg' => 'Old Password do not match']);		
				}
			}else{
				retJson(['_return' => false,'msg' => 'User not found']);	
			}
		}else{
			retJson(['_return' => false,'msg' => '`user`,`oldpassword` and `newpassword` are Required']);
		}
	}

	public function get_notifications_setting()
	{
		if($this->input->post('user')){
			$old = $this->db->get_where('service_provider',['id' => $this->input->post('user')])->row_array();
			if($old){
				retJson(['_return' => true,'data' => $this->service_model->getNotificationSetting($this->input->post('user'))]);
			}else{
				retJson(['_return' => false,'msg' => 'user not found']);
			}
		}else{	
			retJson(['_return' => false,'msg' => '`user` is Required']);
		}
	}

	public function manage_notifications()
	{
		if($this->input->post('user') && $this->input->post('m_email') && $this->input->post('m_text') && $this->input->post('m_push') && $this->input->post('r_email') && $this->input->post('r_text') && $this->input->post('r_push') && $this->input->post('pt_email') && $this->input->post('pt_text') && $this->input->post('pt_push') && $this->input->post('pc_email') && $this->input->post('pc_text') && $this->input->post('pc_push')){
			$user = $this->db->get_where('service_provider',['id' => $this->input->post('user')])->row_array();
			if($user){
				$old = $this->db->get_where('service_notification',['user' => $this->input->post('user')])->row_array();
				if($old){
					$data = [
						'user'			=> $this->input->post('user'),
						'm_email'		=> $this->input->post('m_email'),
						'm_text'		=> $this->input->post('m_text'),
						'm_push'		=> $this->input->post('m_push'),
						'r_email'		=> $this->input->post('r_email'),
						'r_text'		=> $this->input->post('r_text'),
						'r_push'		=> $this->input->post('r_push'),
						'pt_email'		=> $this->input->post('pt_email'),
						'pt_text'		=> $this->input->post('pt_text'),
						'pt_push'		=> $this->input->post('pt_push'),
						'pc_email'		=> $this->input->post('pc_email'),
						'pc_text'		=> $this->input->post('pc_text'),
						'pc_push'		=> $this->input->post('pc_push')
					];
					$this->db->where('user',$this->input->post('user'))->update('service_notification',$data);
				}else{
					$data = [
						'user'			=> $this->input->post('user'),
						'm_email'		=> $this->input->post('m_email'),
						'm_text'		=> $this->input->post('m_text'),
						'm_push'		=> $this->input->post('m_push'),
						'r_email'		=> $this->input->post('r_email'),
						'r_text'		=> $this->input->post('r_text'),
						'r_push'		=> $this->input->post('r_push'),
						'pt_email'		=> $this->input->post('pt_email'),
						'pt_text'		=> $this->input->post('pt_text'),
						'pt_push'		=> $this->input->post('pt_push'),
						'pc_email'		=> $this->input->post('pc_email'),
						'pc_text'		=> $this->input->post('pc_text'),
						'pc_push'		=> $this->input->post('pc_push')
					];
					$this->db->insert('service_notification',$data);
				}
				retJson(['_return' => true,'msg' => 'Notification Settings Saved']);	
			}else{
				retJson(['_return' => false,'msg' => 'user not found']);
			}
		}else{	
			retJson(['_return' => false,'msg' => '`user`,`m_email`,`m_text`,`m_push`,`r_email`,`r_text`,`r_push`,`pt_email`,`pt_text`,`pt_push`,`pc_email`,`pc_text`,`pc_push` are Required']);
		}
	}

	public function logout_device()
	{
		if($this->input->post('user') && $this->input->post('firebase_token')){
			$this->db->where('user',$this->input->post('user'))->where('token',$this->input->post('firebase_token'))->delete('service_firebase');
			retJson(['_return' => true,'msg' => 'Logout Success']);	
		}else{	
			retJson(['_return' => false,'msg' => '`user` and `firebase_token` are Required']);
		}
	}

	public function get_logged_devices()
	{
		if($this->input->post('user')){
			$devices = $this->db->get_where('service_firebase',['user' => $this->input->post('user')]);
			retJson(['_return' => true,'count' => $devices->num_rows(),'list' => $devices->result_array()]);	
		}else{
			retJson(['_return' => false,'msg' => '`user` is Required']);
		}	
	}

	public function logout()
	{
		if($this->input->post('user') && $this->input->post('firebase_token') && $this->input->post('device') && $this->input->post('device_id')){
			$this->db->where('user',$this->input->post('user'))->where('token',$this->input->post('firebase_token'))->where('device',$this->input->post('device'))->where('device_id',$this->input->post('device_id'))->delete('service_firebase');
			retJson(['_return' => true,'msg' => 'Logout Success']);	
		}else{	
			retJson(['_return' => false,'msg' => '`user`,`device`,`device_id` and `firebase_token` are Required']);
		}
	}

	public function verify_profile()
	{
		if($this->input->post('verify_type') && $this->input->post('doctype') && $this->input->post('user') && isset($_FILES ['doc'])){	
			$config['upload_path'] = './uploads/service/doc/';
		    $config['allowed_types']	= '*';
		    $config['max_size']      = '0';
		    $config['overwrite']     = FALSE;
		    $this->load->library('upload', $config);
			if(isset($_FILES ['doc']) && $_FILES['doc']['error'] == 0){
				$doc = microtime(true).".".pathinfo($_FILES['doc']['name'], PATHINFO_EXTENSION);
				$config['file_name'] = $doc;
		    	$this->upload->initialize($config);
		    	if($this->upload->do_upload('doc')){
			    	$data = [
		    			'verify_type'	=> $this->input->post('verify_type'),
		    			'doctpye'		=> $this->input->post('doctype'),
		    			'image'			=> $doc,
		    			'user'			=> $this->input->post('user'),
		    			'status'		=> '1'
		    		];
		    		$this->db->insert('service_verified',$data);
			    	retJson(['_return' => true,'msg' => 'Data uploaded']);		
		    	}else{
		    		retJson(['_return' => false,'msg' => 'File Upload Error']);		
		    	}
			}else{
	    		retJson(['_return' => false,'msg' => 'File Upload Error']);		
	    	}
		}else{
			retJson(['_return' => false,'msg' => '`verify_type`(profile,professional),`user`,`doctype`(a radio button value) and `doc` are Required']);
		}
	}

	public function getprofile()
	{
		if($this->input->post('user')){
			$user = $this->service_model->getServiceData($this->input->post('user'));
			$reviews = $this->db->get_where('service_review',['provider' => $this->input->post('user')])->result_array();
			$reviewsList = [];
			foreach ($reviews as $key => $value) {
				$value['customer_ob']	= $this->customer_model->getCustomerData($value['customer']);
				array_push($reviewsList, $value);
			}
			$user['reviews_list'] = $reviewsList;
			retJson(['_return' => true,'data' => $user]);	
		}else{
			retJson(['_return' => false,'msg' => '`user` is Required']);
		}
	}

	public function address()
	{
		if($this->input->post('lat') && $this->input->post('lon') && $this->input->post('user')){	
			$old = $this->db->get_where('service_address',['user' => $this->input->post('user')])->row_array();
			if($old){
				$city = "";$state = "";$country = "";$area = "";$street = "";
				if($this->input->post('city')){ $city = $this->input->post('city'); }else{ $city = ""; }
				if($this->input->post('state')){ $state = $this->input->post('state'); }else{ $state = ""; }
				if($this->input->post('country')){ $country = $this->input->post('country'); }else{ $country = ""; }
				if($this->input->post('area')){ $area = $this->input->post('area'); }else{ $area = ""; }
				if($this->input->post('street')){ $street = $this->input->post('street'); }else{ $street = ""; }

				$data = [
					'lat'		=> roundLatLon($this->input->post('lat')),
					'lon'		=> roundLatLon($this->input->post('lon')),
					'city'		=> $city,
					'state'		=> $state,
					'country'	=> $country,
					'area'		=> $area,
					'street'	=> $street,
					'user'		=> $this->input->post('user')
				];
				$this->db->where('user',$this->input->post('user'))->update('service_address',$data);

				retJson(['_return' => true,'msg' => "Address Saved"]);	
			}else{
				$city = "";$state = "";$country = "";$area = "";$street = "";
				if($this->input->post('city')){ $city = $this->input->post('city'); }else{ $city = ""; }
				if($this->input->post('state')){ $state = $this->input->post('state'); }else{ $state = ""; }
				if($this->input->post('country')){ $country = $this->input->post('country'); }else{ $country = ""; }
				if($this->input->post('area')){ $area = $this->input->post('area'); }else{ $area = ""; }
				if($this->input->post('street')){ $street = $this->input->post('street'); }else{ $street = ""; }
				$data = [
					'lat'		=> roundLatLon($this->input->post('lat')),
					'lon'		=> roundLatLon($this->input->post('lon')),
					'city'		=> $city,
					'state'		=> $state,
					'country'	=> $country,
					'area'		=> $area,
					'street'	=> $street,
					'user'		=> $this->input->post('user')
				];
				$this->db->insert('service_address',$data);
				retJson(['_return' => true,'msg' => "Address Saved"]);	
			}
		}else{
			retJson(['_return' => false,'msg' => '`lat`,`lon` and `user`(userid) are Required,Optionals are(city,state,country,area,street)']);
		}
	}

	public function login()
	{
		if($this->input->post('type') && $this->input->post('firebase_token') && $this->input->post('device') && $this->input->post('device_id') && $this->input->post('desc')){
			if($this->input->post('type') == 'email'){
				if($this->input->post('email') && $this->input->post('password')){
					$user = $this->db->get_where('service_provider',['email' => $this->input->post('email'),'rtype' => 'email'])->row_array();
					if($user){
						if($user['password'] == md5($this->input->post('password'))){
							if($user['approved'] == '1'){
								$firebase = [
									'desc'		=> $this->input->post('desc'),
									'token'		=> $this->input->post('firebase_token'),
									'device'	=> $this->input->post('device'),
									'device_id'	=> $this->input->post('device_id'),
									'user'		=> $user['id'],
									'cat'		=> _nowDateTime()
								];
								$this->db->insert('service_firebase',$firebase);
								retJson(['_return' => true,'msg' => 'Login Success','data' => $this->service_model->getServiceData($user['id'])]);
							}else{
								retJson(['_return' => false,'msg' => 'Account not approved yet. please contact administrator']);			
							}		
						}else{
							retJson(['_return' => false,'msg' => 'Email and Password not match']);		
						}
					}else{
						retJson(['_return' => false,'msg' => 'Email Not Registered']);	
					}
				}else{
					retJson(['_return' => false,'msg' => '`email` and `password` are Required']);			
				}
			}else if($this->input->post('type') == 'phone'){
				if($this->input->post('phone') && $this->input->post('ccode')){
					$user = $this->db->get_where('service_provider',['phone' => $this->input->post('phone'),'ccode' => $this->input->post('ccode'),'rtype' => 'phone','verified' => '1'])->row_array();
					if($user){
						if($user['approved'] == '1'){
							$otp = generateOtp($user['id'],'service','login');
							retJson(['_return' => true,'msg' => 'Please Verify OTP.','otp' => $otp,'user' => $user['id']]);	
						}else{
							retJson(['_return' => false,'msg' => 'Account not approved yet. please contact administrator']);			
						}
					}else{
						retJson(['_return' => false,'msg' => 'Phone No. Not Registered']);	
					}
				}else{
					retJson(['_return' => false,'msg' => '`phone` id Required']);					
				}
			}else if($this->input->post('type') == 'facebook' || $this->input->post('type') == 'google'){
				if($this->input->post('social_id')){
					$old = $this->db->get_where('service_provider',['social_id' => $this->input->post('social_id'),'rtype' => $this->input->post('type'),'df' => ''])->row_array();
					if($old){
						if($old['approved'] == '1'){
							$firebase = [
								'desc'		=> $this->input->post('desc'),
								'token'		=> $this->input->post('firebase_token'),
								'device'	=> $this->input->post('device'),
								'device_id'	=> $this->input->post('device_id'),
								'user'		=> $old['id'],
								'cat'		=> _nowDateTime()
							];
							$this->db->insert('service_firebase',$firebase);
							retJson(['_return' => true,'msg' => 'Login Success','data' => $this->service_model->getServiceData($old['id'])]);
						}else{
							retJson(['_return' => false,'msg' => 'Account not approved yet. please contact administrator']);			
						}
					}else{
						retJson(['_return' => false,'msg' => 'Not Registered']);				
					}
				}else{
					retJson(['_return' => false,'msg' => '`social_id` is Required']);			
				}
			}else{
				retJson(['_return' => false,'msg' => 'Not Allowed.']);		
			}
		}else{
			retJson(['_return' => false,'msg' => '`type` (email,phone,facebook,google),`device`,`device_id`,`desc` and `firebase_token` are Required']);	
		}
	}

	public function reset_password()
	{
		if($this->input->post('user') && $this->input->post('otp') && $this->input->post('password')){	
			$otp = $this->db->get_where('z_otp',['user' => $this->input->post('user'),'otp' => $this->input->post('otp'),'otptype' => 'forget_password','usertype' => 'service','used' => '0'])->row_array();
			if($otp){
				$this->db->where('id',$this->input->post('user'))->update('service_provider',['password' => md5($this->input->post('password'))]);
				$this->db->where('user',$this->input->post('user'))->where('otptype','forget_password')->where('usertype','service')->update('z_otp',['used' => '1']);
				retJson(['_return' => true,'msg' => 'Password changed.']);	
			}else{
				retJson(['_return' => false,'msg' => 'OTP not match']);	
			}
		}else{
			retJson(['_return' => false,'msg' => '`user`,`otp` are `password` are Required']);
		}
	}

	public function forget_password()
	{
		if($this->input->post('type')){
			if($this->input->post('type') == "email"){
				if($this->input->post('email')){
					$user = $this->db->get_where('service_provider',['email' => $this->input->post('email'),'rtype' => 'email','df' => ''])->row_array();
					if($user){
						$otp = @generateOtp($user['id'],'service','forget_password',true);
						$this->general_model->send_forget_email($user['firstname'].' '.$user['lastname'],$user['email'],$otp);
						retJson(['_return' => true,'msg' => 'Reset password OTP sent to your email','otp' => $otp,'user' => $user['id']]);
					}else{
						retJson(['_return' => false,'msg' => 'Cant find user with this email address.']);	
					}
				}else{
					retJson(['_return' => false,'msg' => '`email` is Required']);		
				}
			}else{
				if($this->input->post('phone') && $this->input->post('ccode')){
					$user = $this->db->get_where('service_provider',['phone' => $this->input->post('phone'),'ccode' => $this->input->post('ccode'),'rtype' => 'email','df' => ''])->row_array();
					if($user){
						$otp = @generateOtp($user['id'],'service','forget_password');
						retJson(['_return' => true,'msg' => 'Reset password OTP sent to your phone no.','otp' => $otp,'user' => $user['id']]);
					}else{
						retJson(['_return' => false,'msg' => 'Cant find user with this phone no.']);	
					}
				}else{
					retJson(['_return' => false,'msg' => '`phone` and `ccode` are Required']);		
				}
			}
		}else{	
			retJson(['_return' => false,'msg' => '`type`(email,phone) is Required']);
		}
	}

	public function registerapi()
	{
		if($this->input->post('type')){
			if ($this->input->post('type') == 'email') {
				if($this->input->post('fname') && $this->input->post('lname') && $this->input->post('email') && $this->input->post('password') && $this->input->post('phone') && $this->input->post('desc') && $this->input->post('ccode')){
					$old = $this->db->get_where('service_provider',['rtype' => 'email','email' => $this->input->post('email'),'df' => '']);
					$oldp = $this->db->get_where('service_provider',['rtype' => 'email','phone' => $this->input->post('phone'),'ccode' => $this->input->post('ccode'),'df' => '']);
					if($old->num_rows() == 0){
						if($oldp->num_rows() == 0){
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
								'rtype'			=> 'email',
								'firstname'		=> $this->input->post('fname'),
								'lastname'		=> $this->input->post('lname'),
								'email'			=> $this->input->post('email'),
								'ccode'			=> $this->input->post('ccode'),
								'phone'			=> $this->input->post('phone'),
								'business'		=> $businessName,
								'services'		=> $servicesAr,
								'descr'			=> $this->input->post('desc'),
								'password'		=> md5($this->input->post('password')),
								'profile_pic'	=> $profileFileName,
								'verified'		=> '1',
								'ref_code'		=> getProviderCode(),
								'cat'			=> _nowDateTime()
							];
							$this->db->insert('service_provider',$data);


							$providerId = $this->db->insert_id();
					
							$old = $this->db->get_where('customer',['rtype' => 'email','email' => $this->input->post('email'),'df' => '']);
							if($old->num_rows() > 0){
								$this->db->where('id',$old->row_array()['id'])->update('customer',['utype' => 'provider','provider_id' => $providerId]);
								$this->db->where('id',$providerId)->update('service_provider',['customer' => $old->row_array()['id']]);
							}else{
								$data = [
									'utype'			=> 'provider',
									'rtype'			=> 'email',
									'firstname'		=> $this->input->post('fname'),
									'lastname'		=> $this->input->post('lname'),
									'email'			=> $this->input->post('email'),
									'ccode'			=> $this->input->post('ccode'),
									'phone'			=> $this->input->post('phone'),
									'password'		=> md5($this->input->post('password')),
									'profile_pic'	=> $profileFileName,
									'verified'		=> '1',
									'provider_id'	=> $providerId,
									'cat'			=> _nowDateTime()
								];
								$this->db->insert('customer',$data);
								$customerId = $this->db->insert_id();
								$this->db->where('id',$providerId)->update('service_provider',['customer' => $customerId]);
							}


							retJson(['_return' => true,'msg' => 'Sign Up Successful.']);
						}else{
							retJson(['_return' => false,'msg' => 'Phone Already Exists.']);	
						}
					}else{
						retJson(['_return' => false,'msg' => 'Email Already Exists.']);
					}
				}else{
					retJson(['_return' => false,'msg' => '`fname`,`lname`,`email`,`phone`,`ccode`,`desc` and `password` are Required,`profileimg`,`business`,`services` is Optional']);	
				}			
			}elseif ($this->input->post('type') == 'phone') {
				if($this->input->post('phone') && $this->input->post('ccode')){
					$old = $this->db->get_where('service_provider',['phone' => $this->input->post('phone'),'ccode' => $this->input->post('ccode'),'df' => '','rtype' => 'phone'])->row_array();
					if($old){
						if($old['verified'] == "1"){
							retJson(['_return' => false,'msg' => 'Phone No. Already Exists']);	
						}else{
							$data = [
								'rtype'		=> 'phone',
								'firstname'	=> "",
								'lastname'	=> "",
								'ccode'		=> $this->input->post('ccode'),
								'phone'		=> $this->input->post('phone'),
								'verified'	=> '0',
								'cat'		=> _nowDateTime()
							];
							$this->db->where('id',$old['id'])->update('service_provider',$data);
							$otp = generateOtp($old['id'],'service','register_phone');
							retJson(['_return' => true,'msg' => 'Please Verify OTP.','user' => $old['id'],'otp' => $otp]);
						}
					}else{
						$data = [
							'rtype'		=> 'phone',
							'firstname'	=> "",
							'lastname'	=> "",
							'ccode'		=> $this->input->post('ccode'),
							'phone'		=> $this->input->post('phone'),
							'verified'	=> '0',
							'ref_code'	=> getProviderCode(),
							'cat'		=> _nowDateTime()
						];
						$this->db->insert('service_provider',$data);
						$user = $this->db->insert_id();
						$otp = generateOtp($user,'service','register_phone');
						retJson(['_return' => true,'msg' => 'Please Verify OTP.','user' => $user,'otp' => $otp]);
					}
				}else{
					retJson(['_return' => false,'msg' => '`phone` and `ccode` are Required']);	
				}
			}elseif ($this->input->post('type') == 'facebook' || $this->input->post('type') == 'google') {
				if($this->input->post('type') && $this->input->post('fname') && $this->input->post('lname') && $this->input->post('email') && $this->input->post('phone') && $this->input->post('desc') && $this->input->post('social_id') && $this->input->post('ccode')){
					$old = $this->db->get_where('service_provider',['social_id' => $this->input->post('social_id'),'rtype' => $this->input->post('type'),'df' => ''])->row_array();
					if(!$old){
						$profile_url = "";
						if($this->input->post('profile_url')){
							$profile_url = $this->input->post('profile_url');
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
							'rtype'			=> $this->input->post('type'),
							'social_id'		=> $this->input->post('social_id'),
							'email'			=> $this->input->post('email'),
							'firstname'		=> $this->input->post('fname'),
							'lastname'		=> $this->input->post('lname'),
							'ccode'			=> $this->input->post('ccode'),
							'phone'			=> $this->input->post('phone'),
							'business'		=> $businessName,
							'services'		=> $servicesAr,
							'descr'			=> $this->input->post('desc'),
							'profile_pic'	=> $profile_url,
							'verified'		=> '1',
							'approved'		=> '0',
							'ref_code'		=> getProviderCode(),
							'cat'			=> _nowDateTime()
						];
						$this->db->insert('service_provider',$data);
						$user = $this->db->insert_id();
						retJson(['_return' => true,'msg' => 'Sign Up Successful.','data' => $this->service_model->getServiceData($user)]);
					}else{
						retJson(['_return' => false,'msg' => 'Already Registered']);	
					}
				}else{
					retJson(['_return' => false,'msg' => '`social_id`,`fname`,`lname`,`email`,`phone`,`ccode`,`desc` are Required,`business`,`services` is optional']);	
				}
			}else{
				retJson(['_return' => false,'msg' => '`type` not found']);	
			}
		}else{
			retJson(['_return' => false,'msg' => '`type`(phone,email,facebook,google) is Required']);
		}
	}
}