<?php
class Transaction_model extends CI_Model
{
	
	public function __construct()
	{
		
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

			$data = [
				'type'			=> traType(1)[1],
				'usertype'		=> 'agent',
				'user'			=> $charge->user,
				'debit'			=> 0.00,
				'credit'		=> $credit,
				'main'			=> $chId,
				'notes'			=> "USSD Payment received.",
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
				'cat'			=> _nowDateTime()
			];
			$this->db->insert('transactions',$data);
		}
	}
}