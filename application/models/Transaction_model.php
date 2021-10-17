<?php
class Transaction_model extends CI_Model
{
	
	public function __construct()
	{
		
	}

	public function posOrder($user,$amount,$main)
	{
		$data = [
			'type'			=> traType(2)[1],
			'usertype'		=> 'agent',
			'user'			=> $user,
			'debit'			=> $amount,
			'credit'		=> 0.00,
			'main'			=> $main,
			'notes'			=> "POS Order",
			'dt'			=> date('Y-m-d'),
			'cat'			=> _nowDateTime()
		];
		$this->db->insert('transactions',$data);
	}

	public function ussdCredited($chId)
	{
		$charge = $this->db->get_where('payment_ussd',['id' => $chId])->row_object();
		if ($charge) {
			if ($charge->cfrom == "buyer") {
				$credit = $charge->amount;
			}else{
				$credit = $charge->amount - ($charge->com + $charge->fcom);
			}

			$checkTrans = $this->db->get_where('transactions',['main' => $chId,'type' => traType(1)[1]])->row_object();
			if (!$checkTrans) {
				$data = [
					'type'			=> traType(1)[1],
					'usertype'		=> 'agent',
					'user'			=> $charge->user,
					'debit'			=> 0.00,
					'credit'		=> $credit,
					'main'			=> $chId,
					'notes'			=> "USSD Payment received.",
					'dt'			=> date('Y-m-d'),
					'cat'			=> _nowDateTime()
				];
				$this->db->insert('transactions',$data);

				$data = [
					'type'			=> traType(1)[1],
					'usertype'		=> 'admin',
					'user'			=> $charge->user,
					'debit'			=> 0.00,
					'credit'		=> $credit,
					'main'			=> $chId,
					'notes'			=> "USSD Payment received.",
					'dt'			=> date('Y-m-d'),
					'cat'			=> _nowDateTime()
				];
				$this->db->insert('transactions',$data);

				$data = [
					'type'			=> traType(2)[1],
					'usertype'		=> 'admin',
					'user'			=> $charge->user,
					'debit'			=> 0.00,
					'credit'		=> $charge->com,
					'main'			=> $chId,
					'notes'			=> "USSD Fees received.",
					'dt'			=> date('Y-m-d'),
					'cat'			=> _nowDateTime()
				];
				$this->db->insert('transactions',$data);	
			}
			
		}
	}

	public function ussdFailed($chId)
	{
		$this->db->where('main',$chId);
		$this->db->where('type',traType(1)[1]);
		$this->db->delete('transactions');
	}
}