<?php
class General_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function getProduct($id)
	{
		$prod = $this->db->get_where('products',['id' => $id])->row_object();

		$prod->image 			=	$this->getProductThumb($id);

		return $prod;
	}

	public function getDistinctUsersFromTransactions()
	{
		$this->db->distinct();
		$this->db->select('user');
		$users = $this->db->get('transactions')->result_object();
		foreach ($users as $key => $value) {
			$users[$key]->name = $this->agent_model->getSomeInfo($value->user)->name;
			$users[$key]->id = $this->agent_model->getSomeInfo($value->user)->id;
		}
		return $users;
	}

	public function getDistinctUsersFromOrders()
	{
		$this->db->distinct();
		$this->db->select('user');
		$users = $this->db->get('orders')->result_object();
		foreach ($users as $key => $value) {
			$users[$key]->name = $this->agent_model->getSomeInfo($value->user)->name;
			$users[$key]->id = $this->agent_model->getSomeInfo($value->user)->id;
		}
		return $users;
	}

	public function getUsersList()
	{
		$this->db->distinct();
		$this->db->select('id,name');
		$this->db->where('df','');
		$this->db->where('block','');
		$users = $this->db->get('register_agent')->result_object();
		return $users;
	}

	public function getBankByCode($id)
	{
		$this->db->select('name');
		$this->db->where('bcode',$id);
		return $this->db->get('master_banks')->row_object();
	}

	public function generateRefId()
	{
		$last = $this->db->order_by('id','desc')->get_where('payment_types')->row_object();
		if ($last) {
			return "USSDPOS".mt_rand(1111,9999).($last->id + 1);
		}else{
			return "USSDPOS".mt_rand(1111,9999).'1';
		}
	}

	public function getStates()
	{
		return $this->db->get_where('master_states',['df' => ''])->result_object();
	}

	public function getRegBanks()
	{
		return $this->db->get_where('master_reg_banks',['df' => ''])->result_object();
	}

	public function getBankThumb($bank)
	{
		$cate = $this->db->get_where('master_banks',['id' => $bank])->row_array();
		if($cate){
			if($cate['image'] != ""){
				if(file_exists(FCPATH.'uploads/master/'.$cate['image'])){
					return base_url('uploads/master/'.$cate['image']);
				}else{
					return base_url('uploads/placeholders/placeholder-long.jpg');
				}
			}else{
				return base_url('uploads/placeholders/placeholder-long.jpg');
			}
		}else{
			return base_url('uploads/placeholders/placeholder-long.jpg');
		}
	}

	public function getCategoryThumb($cate)
	{
		$cate = $this->db->get_where('products_cate',['id' => $cate])->row_array();
		if($cate){
			if($cate['image'] != ""){
				if(file_exists(FCPATH.'uploads/products/'.$cate['image'])){
					return base_url('uploads/products/'.$cate['image']);
				}else{
					return base_url('uploads/placeholders/placeholder512.jpg');
				}
			}else{
				return base_url('uploads/placeholders/placeholder512.jpg');
			}
		}else{
			return base_url('uploads/placeholders/placeholder512.jpg');
		}
	}

	public function getProductThumb($cate)
	{
		$cate = $this->db->get_where('products',['id' => $cate])->row_array();
		if($cate){
			if($cate['image'] != ""){
				if(file_exists(FCPATH.'uploads/products/'.$cate['image'])){
					return base_url('uploads/products/'.$cate['image']);
				}else{
					return base_url('uploads/placeholders/placeholder512.jpg');
				}
			}else{
				return base_url('uploads/placeholders/placeholder512.jpg');
			}
		}else{
			return base_url('uploads/placeholders/placeholder512.jpg');
		}
	}

	public function getProductInfo($cate)
	{
		$cate = $this->db->get_where('products',['id' => $cate])->row_array();
		if($cate){
			if($cate['image'] != ""){
				if(file_exists(FCPATH.'uploads/products/'.$cate['chargeinfo'])){
					return base_url('uploads/products/'.$cate['chargeinfo']);
				}else{
					return base_url('uploads/placeholders/placeholder-long.jpg');
				}
			}else{
				return base_url('uploads/placeholders/placeholder-long.jpg');
			}
		}else{
			return base_url('uploads/placeholders/placeholder-long.jpg');
		}
	}

	public function getHeightWidthOfImage($url)
	{
		$data = @getimagesize($url);
		$width = 512;
		$height = 512;
		if ($data) {
			$width = $data[0];
			$height = $data[1];	
		}
		return $width.','.$height;	
	}

	public function imagesArrayForPhotoSwipe($images)
	{
		$string = "";
		foreach (explode(',', $images) as $key => $value) {
			$str = $value.'='.$this->getHeightWidthOfImage($value).'+';
			$string .= $str;
		}
		return rtrim($string,'+');
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

	public function agentPush($user,$title,$body,$type = '',$dy = []){
		$firebases = $this->db->get_where('firebase_agent',['user' => $user])->result_array();
		$randId = time();
		$url = "https://fcm.googleapis.com/fcm/send";
	    $serverKey = get_setting()['fserverkey'];
		foreach ($firebases as $key => $firebase) {
		    if($firebase['device'] == "iOS"){
		        $notification = array('title' => $title, 'body' => $body,'sound' => 'default','badge' => '0');
		        $arrayToSend = array('registration_ids' => [$firebase['token']],"priority" => "high","notification" => $notification,'data' => ['title' => $title,'body' => $body,'type' => $type,'dy' => $dy]);
		    }else{
		        $arrayToSend = array('registration_ids' => [$firebase['token']],"priority" => "high",'data' => ['notid' => $randId,'title' => $title,'body' => $body,'type' => $type,'dy' => $dy]);
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

	public function sendNotificationsToAndroidDevices($tokens,$title,$body,$type = '',$dy = [])
	{
		$randId = time();
		$url = "https://fcm.googleapis.com/fcm/send";
	    $serverKey = get_setting()['fserverkey'];
	    $arrayToSend = array('registration_ids' => $tokens,"priority" => "high",'data' => ['notid' => $randId,'title' => $title,'body' => $body,'type' => $type,'dy' => $dy]);
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

	public function get_page($id)
	{
		return $this->db->get_where('cms_pages',['id' => $id])->row_array();	
	}

	public function get_setting()
	{
		return $this->db->get_where('setting',['id' => '1'])->row_array();
	}

	public function send_mail($to,$subject,$body)
	{
		$this->load->library('phpmailer_library');
        $mail = $this->phpmailer_library->load();
        $mail->isSMTP();
        $mail->Host     = get_setting()['mail_host'];
        $mail->SMTPAuth = true;
        $mail->Username = get_setting()['mail_username'];
        $mail->Password = get_setting()['mail_pass'];
        $mail->SMTPSecure = 'ssl';
        $mail->Port     = get_setting()['mail_port'];
        $mail->setFrom(get_setting()['mail_username'], get_setting()['name']);
        $mail->addReplyTo(get_setting()['mail_username'], get_setting()['name']);

        foreach (explode(',', $to) as $key => $value) {
        	$mail->addAddress($value);
        }

        // Add cc or bcc 
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        $mail->Subject = $subject;

        // Set email format to HTML
        $mail->isHTML(true);
        $mail->Body = html_entity_decode($body);
        if(!$mail->send()){
            // echo 'Message could not be sent.';
            // echo 'Mailer Error: ' . $mail->ErrorInfo;
        }else{
            //echo 'Message has been sent';
        }
	}

	public function sendSms($to,$msg,$gateWay = 1)
	{
			$curl = curl_init();
			$url = 'http://bulksmsnigeria.com/api/v2/sms/create?api_token='.get_setting()['bulksmskey'].'&from='.get_setting()['bulksmskey'].'&to='.$to.'&body='.urlencode($msg).'&gateway='.$gateWay.'&dnd=6';
			curl_setopt_array($curl, array(
			  	CURLOPT_URL => $url,
			  	CURLOPT_RETURNTRANSFER => true,
			  	CURLOPT_SSL_VERIFYPEER => false,
			  	CURLOPT_ENCODING => '',
			  	CURLOPT_MAXREDIRS => 10,
			  	CURLOPT_TIMEOUT => 0,
			  	CURLOPT_FOLLOWLOCATION => true,
			 	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  	CURLOPT_CUSTOMREQUEST => 'GET',
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			if ($err) {
			    //return "cURL Error #:" . $err;
			} else {
			    //return $response;
			}
	}

	public function nigeriaBulkSms($to,$msg)
	{
		$curl = curl_init();
		$url = 'https://portal.nigeriabulksms.com/api/?username='.urlencode(get_setting()['nsmsuser']).'&password='.urlencode(get_setting()['nsmspass']).'&message='.urlencode($msg).'&sender='.urlencode(get_setting()['nsmssendid']).'&mobiles='.urlencode($to);
		curl_setopt_array($curl, array(
		  	CURLOPT_URL => $url,
		  	CURLOPT_RETURNTRANSFER => true,
		  	CURLOPT_SSL_VERIFYPEER => false,
		  	CURLOPT_ENCODING => '',
		  	CURLOPT_MAXREDIRS => 10,
		  	CURLOPT_TIMEOUT => 0,
		  	CURLOPT_FOLLOWLOCATION => true,
		 	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  	CURLOPT_CUSTOMREQUEST => 'GET',
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
		    //return "cURL Error #:" . $err;
		} else {
		    //return $response;
		}
	}
}
?>