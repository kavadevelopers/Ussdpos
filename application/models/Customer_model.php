<?php
class Customer_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function getCustomerData($id)
	{
	    $customer = $this->db->get_where('customer',['id' => $id])->row_array();
	    if($customer['rtype'] == 'email' || $customer['rtype'] == 'phone'){
	        if($customer['profile_pic'] != "" && $customer['profile_pic'] != NULL){
	            $customer['profile_pic'] = base_url('uploads/customer/').$customer['profile_pic'];
	        }else{
	            $customer['profile_pic'] = base_url('uploads/common/profile.png');
	        }
	    }else{
	        if($customer['profile_pic'] != "" && $customer['profile_pic'] != NULL){
	            if(filter_var($customer['profile_pic'], FILTER_VALIDATE_URL)){
	            	$customer['profile_pic'] = $customer['profile_pic'];
	        	}else{
	        		$customer['profile_pic'] = base_url('uploads/customer/').$customer['profile_pic'];
	        	}
	        }else{
	            $customer['profile_pic'] = base_url('uploads/common/profile.png');
	        }
	    }
	    $customer['usertype']   		= "customer";
	    $customer['address']    		= $this->db->get_where('customer_address',['user' => $id])->row_array();
	    $customer['verified_profile']	= $this->is_verified($id);
	    $customer['occupations']		= $this->getOccupations($customer);
	    $customer['skills']				= $this->getSkills($customer);
	    $customer['educations']			= $this->getEducations($id);
	    $customer['review']				= $this->getReviewsCustomer($id);
	    return $customer;
	}

	public function is_verified($id)
	{
		$verified = $this->db->get_where('customer_verified',['user' => $id,'status' => '1'])->row_array();
		if($verified){
			return "1";
		}else{
			return "0";
		}
	}

	public function getOccupations($customer)
	{
		if($customer['occupations'] != NULL){
			$ar = [];
			foreach (explode(',', $customer['occupations']) as $key => $value) {
				$occ = getOccupations($value);
				array_push($ar, $occ);
			}
			return $ar;
		}else{
			return NULL;
		}
	}

	public function getSkills($customer)
	{
		if($customer['skills'] != NULL){
			$ar = [];
			foreach (explode(',', $customer['skills']) as $key => $value) {
				$occ = getSkills($value);
				array_push($ar, $occ);
			}
			return $ar;
		}else{
			return NULL;
		}
	}

	public function getEducations($id)
	{
		return $this->db->get_where('customer_education',['user' => $id])->result_array();
	}

	public function getReviewsCustomer($customer)
	{
		$countTotal = $this->db->get_where('customer_review',['customer' => $customer])->num_rows();
		$old1 = 0.00; 
		$this->db->select_sum('cleanliness');
		$this->db->where('customer',$customer);
		$this->db->from('customer_review');
		$rev1 = $this->db->get()->row();
		if($rev1){
			$old1 = $rev1->cleanliness;
		}

		if ($old1 > 0) {
			$rating1 = ($old1 * 5) / ($countTotal * 5);
		}else{
			$rating1 = 0.00;
		}

		$old2 = 0.00; 
		$this->db->select_sum('communication');
		$this->db->where('customer',$customer);
		$this->db->from('customer_review');
		$rev2 = $this->db->get()->row();
		if($rev2){
			$old2 = $rev2->communication;
		}

		if ($old2 > 0) {
			$rating2 = ($old2 * 5) / ($countTotal * 5);
		}else{
			$rating2 = 0.00;
		}


		$old3 = 0.00; 
		$this->db->select_sum('checkin');
		$this->db->where('customer',$customer);
		$this->db->from('customer_review');
		$rev3 = $this->db->get()->row();
		if($rev3){
			$old3 = $rev3->checkin;
		}

		if ($old3 > 0) {
			$rating3 = ($old3 * 5) / ($countTotal * 5);	
		}else{
			$rating3 = 0.00;
		}


		$old4 = 0.00; 
		$this->db->select_sum('ob_shop_rules');
		$this->db->where('customer',$customer);
		$this->db->from('customer_review');
		$rev4 = $this->db->get()->row();
		if($rev4){
			$old4 = $rev4->ob_shop_rules;
		}
		if ($old4 > 0) {
			$rating4 = ($old4 * 5) / ($countTotal * 5);	
		}else{
			$rating4 = 0.00;
		}
		
		$totalReview = ($rating1 + $rating2 + $rating3 + $rating4);
		if ($totalReview > 0) {
			$avarage = ($totalReview * 5) / (4 * 5);
		}else{
			$avarage = 0.00;
		}
		return [
			'review_count'		=> $countTotal,
			'avarage'			=> $avarage,
			'cleanliness'		=> $rating1,
			'communication'		=> $rating2,
			'checkin'			=> $rating3,
			'ob_shop_rules'		=> $rating4
		];
	}
}