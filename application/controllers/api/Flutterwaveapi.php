<?php
class Flutterwaveapi extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('Flutterwave');
	}




	public function check()
	{
		@$this->payment_model->ussdCredited($this->input->post('charge'));
	}

	public function ussd_charge_continue_check()
	{
		if ($this->input->post('user') && $this->input->post('chid')) {
			$charge = $this->db->get_where('payment_ussd',['id' => $this->input->post('chid')])->row_object();
			if ($charge) {
				if ($charge->status == "1") {
					retJson(['_return' => true,'msg' => 'Payment successful']);			
				}else if ($charge->status == "2") {
					retJson(['_return' => true,'msg' => 'Payment failed']);			
				}else{
					retJson(['_return' => false,'msg' => '']);			
				}
			}else{
				retJson(['_return' => false,'msg' => 'Error Please Try again later.']);	
			}
		}else{
			retJson(['_return' => false,'msg' => '`user`,`chid` are Required']);
		}	
	}

	public function verify_ussd_payment()
	{
		if ($this->input->post('user') && $this->input->post('chid')) {	
			$charge = $this->db->get_where('payment_ussd',['id' => $this->input->post('chid')])->row_object();
			if ($charge) {
				$getCharge = $this->flutterwave->verifyUSSDPayment($charge->chid);
				if ($getCharge != "") {
					$response = json_decode($getCharge);
					if($response->data->status == "pending"){
						retJson(['_return' => false,'msg' => 'Payment is pending please wait..']);			
					}else if($response->data->status == "successful"){
						$this->db->where('id',$this->input->post('chid'))->update('payment_ussd',['status' => '1']);
						$this->db->where('pay',$this->input->post('chid'))->update('payment_types',['status' => '1']);

						@$this->payment_model->ussdCredited($charge->id);


						retJson(['_return' => true,'msg' => 'Payment successful']);			
					}else{
						$this->db->where('id',$this->input->post('chid'))->update('payment_ussd',['status' => '2']);
						$this->db->where('pay',$this->input->post('chid'))->update('payment_types',['status' => '2']);
						retJson(['_return' => true,'msg' => 'Payment failed']);	
					}
				}else{
					retJson(['_return' => false,'msg' => 'Error Please Try again later.']);		
				}
			}else{
				retJson(['_return' => false,'msg' => 'Error Please Try again later.']);	
			}
		}else{
			retJson(['_return' => false,'msg' => '`user`,`chid` are Required']);
		}
	}

	public function ussdcharge()
	{
		if ($this->input->post('user') && $this->input->post('comfrom') && $this->input->post('bank') && $this->input->post('amount')) {
			$refId 			= $this->general_model->generateUssdRefId();
			$userData 		= $this->agent_model->get($this->input->post('user'));
			$comAr 			= $this->commission_model->getUssdComission($this->input->post('amount'));			
			$mobile 		= $userData->phone; 
			$narration 		= ""; 
			$name 			= $userData->name; 
			$email 			= $userData->email;
			if ($this->input->post('mobile')) {
				$mobile 	= $this->input->post('mobile');
			}
			if ($this->input->post('narration')) {
				$narration 	= $this->input->post('narration');
			}
			
			$bank 			= $this->input->post('bank');
			$amount 		= $this->input->post('amount');
			$com 			= $comAr['com'];
			$fcom 			= $comAr['fcom'];
			$payableAmount 	= $amount;
			if ($this->input->post('comfrom') == "buyer") {
				$payableAmount 	= $amount + $com;
			}

			$charge = $this->flutterwave->ChargeUSSD($refId,$bank,$payableAmount,$email,$mobile,$name);
			if ($charge != "") {
				$response = json_decode($charge);
				if ($response->status == "success") {
					$data = [
						'user' 		=> $this->input->post('user'),
						'chid'		=> $response->data->id,
						'ref'		=> $refId,
						'flw_ref'	=> $response->data->flw_ref,
						'bank'		=> $bank,
						'cfrom'		=> $this->input->post('comfrom'),
						'amount'	=> $amount,
						'com'		=> $com,
						'fcom'		=> $fcom,
						'narration'	=> $narration,
						'mobile'	=> $mobile,
						'ussd'		=> $response->meta->authorization->note,
						'status'	=> '0',
						'cat'		=> _nowDateTime()
					];
					$this->db->insert('payment_ussd',$data);
					$chrgeId = $this->db->insert_id();

					$data = [
						'user' 		=> $this->input->post('user'),
						'pay'		=> $chrgeId,
						'type'		=> 'ussd',
						'ref'		=> $refId,
						'flw_ref'	=> $response->data->flw_ref,
						'chid'		=> $response->data->id,
						'status'	=> '0',
						'cat'		=> _nowDateTime()
					];
					$this->db->insert('payment_types',$data);

					if ($this->input->post('comfrom') == "buyer") {
						$payableAmount 	= $amount + $com + $fcom;
					}else{
						$payableAmount 	= $amount;
					}

					retJson([
						'_return' 			=> true,
						'msg' 				=> 'Charge Created',
						'ussd' 				=> $response->meta->authorization->note,
						'charge'			=> $chrgeId,
						'amount'			=> ptPretyAmount($amount),
						'fees'				=> ptPretyAmount($com + $fcom),
						'payable'			=> ptPretyAmount($payableAmount),
						'cpayby'			=> $this->input->post('comfrom')
					]);	
				}else{
					retJson(['_return' => false,'msg' => 'Error Please Try again later.']);	
				}
			}else{
				retJson(['_return' => false,'msg' => 'Error Please Try again later.']);	
			}
		}else{
			retJson(['_return' => false,'msg' => '`user`,`bank`,`amount`,`comfrom`(buyer,seller) are Required,`mobile`,`narration` are Optional']);
		}
	}

	public function webhook_success()
	{
		$body = @file_get_contents("php://input");
		$signature = (isset($_SERVER['HTTP_VERIF_HASH']))?$_SERVER['HTTP_VERIF_HASH']:'';
		if(empty($signature) || $signature != get_setting()['fluter_web_hash']){
            exit();
        }else{
        	$response = json_decode($body,1);
			$paymentRow = $this->db->get_where('payment_types',['chid' => $response['id']])->row_object();
			if ($paymentRow) {
				$this->db->where('chid',$response['id'])->update('payment_types',['status' => '1']);
				if ($paymentRow->type == "ussd") {
					$this->db->where('chid',$response['id'])->update('payment_ussd',['status' => '1']);
					$charge = $this->db->get_where('payment_ussd',['chid' => $response['id']])->row_object();
					if ($charge) {
						@$this->payment_model->ussdCredited($charge->id);
					}
				}
			}
        }
		
		




		// $this->load->helper('file');
		// if (!write_file('./uploads/'.microtime(true).'.txt', $body)){
		//      //echo 'Unable to write the file';
		// }
	}

	public function webhook_failed()
	{
		$body = @file_get_contents("php://input");
		$signature = (isset($_SERVER['HTTP_VERIF_HASH']))?$_SERVER['HTTP_VERIF_HASH']:'';
		if(empty($signature) || $signature != get_setting()['fluter_web_hash']){
            exit();
        }else{
        	$response = json_decode($body,1);
			$paymentRow = $this->db->get_where('payment_types',['chid' => $response['id']])->row_object();
			if ($paymentRow) {
				$this->db->where('chid',$response['id'])->update('payment_types',['status' => '2']);
				if ($paymentRow->type == "ussd") {
					$this->db->where('chid',$response['id'])->update('payment_ussd',['status' => '2']);
				}
			}
        }

		// $this->load->helper('file');
		// if (!write_file('./uploads/'.microtime(true).'.txt', 'Failed-'.$body)){
		//      //echo 'Unable to write the file';
		// }
	}
}