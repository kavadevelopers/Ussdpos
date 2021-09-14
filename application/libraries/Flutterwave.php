<?php
class Flutterwave{
	var $apiKey;
	var $CI;
	var $currency;
	public function __construct()
	{
		$this->CI =& get_instance();
		$setting = get_setting();
		$this->apiKey = $setting['flutterapi']; 
		$this->currency = 'NGN';
	}

	public function verifyUSSDPayment($chid)
	{
		$curl = curl_init();
		$url = 'https://api.flutterwave.com/v3/transactions/'.$chid.'/verify';
		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authorization: Bearer '.$this->apiKey,
			    "cache-control: no-cache"
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}

	public function ChargeUSSD($tx_ref,$account_bank,$amount,$email,$phone,$name)
	{
		$postFields = '{
		    "tx_ref": "'.$tx_ref.'",
		    "account_bank": "'.$account_bank.'",
		    "amount": "'.$amount.'",
		    "currency": "'.$this->currency.'",
		    "email": "'.$email.'",
		    "phone_number": "'.$phone.'",
		    "fullname": "'.$name.'"
		}';
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://api.flutterwave.com/v3/charges?type=ussd',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => $postFields,
		  	CURLOPT_HTTPHEADER => array(
		    	'Content-Type: application/json',
		    	'Authorization: Bearer '.$this->apiKey,
		    	"cache-control: no-cache"
		  	),
		));

		$response = curl_exec($curl);
		// if (curl_errno($curl)) {
		//     $error_msg = curl_error($curl);
		// }
		curl_close($curl);
		return $response;
		// if (!isset($error_msg)) {
		// 	return $response;
		// }else{
		// 	return $error;
		// }
	}
}