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
		$user->name = ucfirst($user->name);
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

	public function sendNotificationsToAndroidDevices($tokens,$title,$body,$type = '',$dy = [])
	{
		$url = "https://fcm.googleapis.com/fcm/send";
	    $serverKey = get_setting()['fserverkey'];
	    $arrayToSend = array('registration_ids' => $tokens,"priority" => "high",'data' => ['title' => $title,'body' => $body,'type' => $type,'dy' => $dy]);
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

        $mail->addAddress($to);

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

	public function sendSms($to,$msg)
	{
		
	}
}
?>