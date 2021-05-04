<?php
class Payments extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_provider_request_list()
	{
		if($this->input->post('user') && $this->input->post('booking')){
			$reqListOpen = $this->db->get_where('request_money',[
				't' => $this->input->post('user'),'booking' => $this->input->post('booking'),'status' => '0'
			])->result_array();
			foreach ($reqListOpen as $key => $value) {
				$reqListOpen[$key]['provider_ob']	= $this->service_model->getServiceData($value['t']);
				$reqListOpen[$key]['customer_ob']	= $this->customer_model->getCustomerData($value['f']);
			}

			$reqListClose = $this->db->get_where('request_money',[
				't' => $this->input->post('user'),'booking' => $this->input->post('booking'),'status' => '1'
			])->result_array();
			foreach ($reqListClose as $key => $value) {
				$reqListClose[$key]['provider_ob']	= $this->service_model->getServiceData($value['t']);
				$reqListClose[$key]['customer_ob']	= $this->customer_model->getCustomerData($value['f']);
			}

			retJson(['_return' => true,'open' => $reqListOpen,'close' => $reqListClose]);
		}else{
			retJson(['_return' => false,'msg' => '`user`,`booking` are Required']);
		}	
	}

	public function get_customer_request_list()
	{
		if($this->input->post('user') && $this->input->post('booking')){
			$reqListOpen = $this->db->get_where('request_money',[
				'f' => $this->input->post('user'),'booking' => $this->input->post('booking'),'status' => '0'
			])->result_array();
			foreach ($reqListOpen as $key => $value) {
				$reqListOpen[$key]['provider_ob']	= $this->service_model->getServiceData($value['t']);
				$reqListOpen[$key]['customer_ob']	= $this->customer_model->getCustomerData($value['f']);
			}

			$reqListClose = $this->db->get_where('request_money',[
				'f' => $this->input->post('user'),'booking' => $this->input->post('booking'),'status' => '1'
			])->result_array();
			foreach ($reqListClose as $key => $value) {
				$reqListClose[$key]['provider_ob']	= $this->service_model->getServiceData($value['t']);
				$reqListClose[$key]['customer_ob']	= $this->customer_model->getCustomerData($value['f']);
			}

			retJson(['_return' => true,'open' => $reqListOpen,'close' => $reqListClose]);
		}else{
			retJson(['_return' => false,'msg' => '`user`,`booking` are Required']);
		}	
	}

	public function set_status()
	{
		if($this->input->post('request_id') && $this->input->post('status')){
			if($this->input->post('status') == "reject"){
				$this->db->where('id',$this->input->post('request_id'))->update('request_money',['status' => '1','snotes' => 'Rejected']);
				retJson(['_return' => true,'msg' => 'Status Changed']);
			}else{
				if($this->input->post('reason') && $this->input->post('refund_type') && $this->input->post('amount') && $this->input->post('note')){
					$partial = '0';
					if($this->input->post('refund_type') == "partial"){
						$partial = '1';
					}
					$data = [
						'reason2'					=> $this->input->post('reason'),	
						'partial'					=> $partial,	
						'paid_amount'				=> $this->input->post('amount'),	
						'notes_from_provider'		=> $this->input->post('note')
					];
					$this->db->where('id',$this->input->post('request_id'))->update('request_money',$data);
					retJson(['_return' => true,'msg' => 'Status Changed']);
				}else{
					retJson(['_return' => false,'msg' => '`reason`,`refund_type`(full,partial),amount,note are Required']);		
				}	
			}
		}else{
			retJson(['_return' => false,'msg' => '`request_id`,`status`(approve,reject) are Required']);
		}
	}

	public function request_money()
	{
		if($this->input->post('from') && $this->input->post('to') && $this->input->post('booking') && $this->input->post('amount') && $this->input->post('reason') && $this->input->post('message')){
			
			$this->other_model->saveNotification(
				$this->input->post('booking'),
				'booking',
				$this->input->post('to'),
				'provider',
				'Request Money '.$this->input->post('reason'),
				$this->input->post('message')
			);

			$this->general_model->servicePush(
				$this->input->post('provider'),
				'Request Money '.$this->input->post('reason'),
				$this->input->post('message')
			);

			$data = [
				'f'				=> $this->input->post('from'),	
				't'				=> $this->input->post('to'),	
				'ftype'			=> "customer",	
				'booking'		=> $this->input->post('booking'),	
				'amount'		=> $this->input->post('amount'),	
				'reason'		=> $this->input->post('reason'),	
				'message'		=> $this->input->post('message'),
				'cat'			=> _nowDateTime()
			];
			$this->db->insert('request_money',$data);
			retJson(['_return' => true,'msg' => 'Request Sent']);
		}else{
			retJson(['_return' => false,'msg' => '`from`,`to`,`booking`,`amount`,`reason`,`message` are Required']);
		}
	}
}