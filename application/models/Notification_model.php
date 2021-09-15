<?php
class Notification_model extends CI_Model
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


			$template = 'Hi there, you received payment of '.niara().ptPretyAmount($credit).' Thankyou';
			@$this->general_model->agentPush(
				$charge->user,
				'USSD Payment received',
				$template
			);
		}
	}
}