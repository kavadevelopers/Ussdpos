<?php
class General_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function getUser($user)
	{
		$user = $this->db->get_where('register_agent',['id' => $user])->row_object();
		$userDet = $this->db->get_where('details_agent',['user' => $user->id])->row_object();
		$userDet->fileprofile = $this->getFile($userDet->fileprofile,'uploads/agent/');
		$user->detail	= $userDet;
		return $user;
	}

	public function getFile($file,$folder)
	{
		if ($file != "") {
			if (file_exists(FCPATH.$folder.$file)) {
				return base_url($folder.$file);
			}else{
				return "";
			}
		}else{
			return "";
		}
	}


	public function customerPush($customer,$title,$body,$type = '',$dy = []){
		$firebases = $this->db->get_where('customer_firebase',['user' => $customer])->result_array();
		$url = "https://fcm.googleapis.com/fcm/send";
	    $serverKey = get_setting()['fserverkey'];
		foreach ($firebases as $key => $firebase) {
		    if($firebase['device'] == "iOS"){
		        $notification = array('title' => $title, 'body' => $body,'sound' => 'default','badge' => '0');
		        $arrayToSend = array('registration_ids' => [$firebase['token']],"priority" => "high","notification" => $notification,'data' => ['title' => $title,'body' => $body,'type' => $type,'dy' => $dy]);
		    }else{
		        $arrayToSend = array('registration_ids' => [$firebase['token']],"priority" => "high",'data' => ['title' => $title,'body' => $body,'type' => $type,'dy' => $dy]);
		    }
		    $json = json_encode($arrayToSend);
		    $headers = array();
		    $headers[] = 'Content-Type: application/json';
		    $headers[] = 'Authorization: key='. $serverKey;
		    $ch = curl_init();
		    //pre_print($arrayToSend);
		    curl_setopt($ch, CURLOPT_URL, $url);
		    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
		    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		    curl_setopt($ch, CURLOPT_VERBOSE, 0); 
		    $result = curl_exec($ch);
		    curl_close($ch);
		}
	}

	public function servicePush($provider,$title,$body,$type = '',$dy = []){
		$firebases = $this->db->get_where('service_firebase',['user' => $provider])->result_array();
		$url = "https://fcm.googleapis.com/fcm/send";
	    $serverKey = get_setting()['fserverkey'];
		foreach ($firebases as $key => $firebase) {
		    if($firebase['device'] == "iOS"){
		        $notification = array('title' => $title, 'body' => $body,'sound' => 'default','badge' => '0');
		        $arrayToSend = array('registration_ids' => [$firebase['token']],"priority" => "high","notification" => $notification,'data' => ['title' => $title,'body' => $body,'type' => $type,'dy' => $dy]);
		    }else{
		        $arrayToSend = array('registration_ids' => [$firebase['token']],"priority" => "high",'data' => ['title' => $title,'body' => $body,'type' => $type,'dy' => $dy]);
		    }
		    $json = json_encode($arrayToSend);
		    $headers = array();
		    $headers[] = 'Content-Type: application/json';
		    $headers[] = 'Authorization: key='. $serverKey;
		    $ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL, $url);
		    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
		    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		    curl_setopt($ch, CURLOPT_VERBOSE, 0); 
		    $result = curl_exec($ch);
		    curl_close($ch);
		}
	}

	public function getCategory($id)
	{
		$category = $this->db->get_where('categories',['id' => $id])->row_array();
		$category['image']	= $this->general_model->getCategoryThumb($category['id']);
		return $category;
	}

	public function getFavFolders($user)
	{
		$this->db->where('user',$user);
		$list = $this->db->get('others_favourite_folders')->result_array();
		foreach ($list as $key => $value) {
			$prods = $this->db->get_where('others_favourite_products',['folder' => $value['id']])->result_array();
			$image = ""; $prodsCount = 0;
			foreach ($prods as $pkey => $pvalue) {
				$prod = $this->shop_model->getProduct($pvalue['product']);
				if($prod && $prod['df'] == ""){
					$prodsCount++;
					if ($image == "" && $prod['images']) {
						$image = $prod['images'][0]['image'];
					}
				}	
			}
			if($image == ""){
				$image = base_url('uploads/placeholders/placeholder512.png');
			}
			$list[$key]['image'] = $image;
			$list[$key]['prods'] = $prodsCount;
		}
		return $list;
	}

	public function insertServiceDetails($user)
	{
		$old = $this->db->get_where('service_provider_details',['user' => $user])->row_array();
		if(!$old){
			$this->db->insert('service_provider_details',['user' => $user]);
		}
	}

	public function get_page($id)
	{
		return $this->db->get_where('pages',['id' => $id])->row_array();	
	}

	public function get_setting()
	{
		return $this->db->get_where('setting',['id' => '1'])->row_array();
	}

	public function getShopId()
	{
		$last_id = $this->db->order_by('id','desc')->limit(1)->get('shop')->row_array();	
		if($last_id){
			return mt_rand(10000000, 99999999).($last_id['id'] + 1);
		}else{
			return mt_rand(10000000, 99999999).'1';
		}
	}

	public function getCategoryThumb($category)
	{
		$cate = $this->db->get_where('categories',['id' => $category])->row_array();
		if($cate){
			if($cate['image'] != ""){
				if(file_exists(FCPATH.'uploads/category/'.$cate['image'])){
					return base_url('uploads/category/'.$cate['image']);
				}else{
					return base_url('uploads/common/thumbnail.png');
				}
			}else{
				return base_url('uploads/common/thumbnail.png');
			}
		}else{
			return base_url('uploads/common/thumbnail.png');
		}
	}

	public function send_forget_email($name,$to,$otp)
	{
		$msg = $this->load->view('mail/reset_password',['name' => $name,'otp' => $otp],true);
	    $this->load->library('email');
	    $config = array(
	        'protocol'      => 'SMTP',
	        'smtp_host' => get_setting()['mail_host'],
	        'smtp_port' => get_setting()['mail_port'],
	        'smtp_user' => get_setting()['mail_username'],
	        'smtp_pass' => get_setting()['mail_pass'],
	        'mailtype'      => 'html',
	        'charset'       => 'utf-8'
	    );
	    $this->email->initialize($config);
	    $this->email->set_mailtype("html");
	    $this->email->set_newline("\r\n");
	    $this->email->to($to);
	    $this->email->from(get_setting()['mail_username']);
	    $this->email->subject("Forget Password OTP.");
	    $this->email->message($msg);
	    if($this->email->send()){
	        //echo "ok";
	    }else{
	        //echo $CI->email->print_debugger();
	    }
	}
}
?>