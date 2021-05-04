<?php
class Service_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function getServiceData($id)
	{
	    $customer = $this->db->get_where('service_provider',['id' => $id])->row_array();
	    if($customer['rtype'] == 'email' || $customer['rtype'] == 'phone'){
	        if($customer['profile_pic'] != "" && $customer['profile_pic'] != NULL){
	            $customer['profile_pic'] = base_url('uploads/service/').$customer['profile_pic'];
	        }else{
	            $customer['profile_pic'] = base_url('uploads/common/profile.png');
	        }
	    }else{
	        if($customer['profile_pic'] != "" && $customer['profile_pic'] != NULL){
	        	if(filter_var($customer['profile_pic'], FILTER_VALIDATE_URL)){
	            	$customer['profile_pic'] = $customer['profile_pic'];
	        	}else{
	        		$customer['profile_pic'] = base_url('uploads/service/').$customer['profile_pic'];
	        	}
	        }else{
	            $customer['profile_pic'] = base_url('uploads/common/profile.png');
	        }
	    }
	    if($customer['package'] != null || $customer['package'] != "" || $customer['package'] != '1'){
	    	$customer['last_purchased']		= $this->db->order_by('id','desc')->get_where('package_purchased',['user' => $id])->row_array();
	    }
	    $services = [];
	    foreach (explode(',', $customer['services']) as $Skey => $service) {
	    	$categories = $this->db->get_where('categories',['id' => $service])->row_array();
	    	if($categories){
		    	$categories['image']	= $this->general_model->getCategoryThumb($service);
		    	array_push($services, $categories);
		    }
	    }
	    $customer['services_ob']			= $services;
	    $customer['package_ob']				= $this->db->get_where('packages',['id' => $customer['package']])->row_array();
	    $customer['usertype']   			= "service";
	    $customer['address']    			= $this->db->get_where('service_address',['user' => $id])->row_array();
	    $customer['verified_profile']		= $this->is_verified($id);
	    $customer['verified_professional']	= $this->is_verified_professional($id);
	    $customer['other_details']			= $this->db->get_where('service_provider_details',['user' => $id])->row_array();
	    $customer['timing']					= $this->db->get_where('service_timing',['service' => $id])->row_array();
	    return $customer;
	}

	public function is_verified($id)
	{
		$verified = $this->db->order_by('id','desc')->get_where('service_verified',['verify_type' => 'profile','user' => $id])->row_array();
		if($verified){
			return $verified['status'];
		}else{
			return "0";
		}
	}

	public function is_verified_professional($id)
	{
		$verified = $this->db->order_by('id','desc')->get_where('service_verified',['verify_type' => 'professional','user' => $id])->row_array();
		if($verified){
			return $verified['status']; // notes : 0 not uploaded,1 uploaded,2 reject,3 accept
 		}else{
			return "0";
		}
	}

	public function getNotificationSetting($user)
	{
		$old = $this->db->get_where('service_notification',['user' => $user])->row_array();
		if($old){
			return $old;
		}else{
			$data = [
				'm_email'		=> 0,
				'm_text'		=> 0,
				'm_push'		=> 1,
				'r_email'		=> 1,
				'r_text'		=> 1,
				'r_push'		=> 1,
				'pt_email'		=> 1,
				'pt_text'		=> 1,
				'pt_push'		=> 1,
				'pc_email'		=> 1,
				'pc_text'		=> 1,
				'pc_push'		=> 1
			];
			return $data;
		}
	}
}