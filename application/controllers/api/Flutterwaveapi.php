<?php
class Flutterwaveapi extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('Flutterwave');
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
				$payableAmount 	= $amount + $com + $fcom;
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

					retJson([
						'_return' 			=> true,
						'msg' 				=> 'Charge Created',
						'ussd' 				=> $response->meta->authorization->note,
						'charge'			=> $chrgeId
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
		$response = json_decode($body,1);
		$paymentRow = $this->db->get_where('payment_types',['chid' => $response['id']])->row_object();
		if ($paymentRow) {
			$this->db->where('chid',$response['id'])->update('payment_types',['status' => '1']);
			if ($paymentRow->type == "ussd") {
				$this->db->where('id',$response['pay'])->update('payment_ussd',['status' => '1']);
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
		$response = json_decode($body,1);
		$paymentRow = $this->db->get_where('payment_types',['chid' => $response['id']])->row_object();
		if ($paymentRow) {
			$this->db->where('chid',$response['id'])->update('payment_types',['status' => '2']);
			if ($paymentRow->type == "ussd") {
				$this->db->where('id',$response['pay'])->update('payment_ussd',['status' => '2']);
			}
		}

		// $this->load->helper('file');
		// if (!write_file('./uploads/'.microtime(true).'.txt', 'Failed-'.$body)){
		//      //echo 'Unable to write the file';
		// }
	}
}