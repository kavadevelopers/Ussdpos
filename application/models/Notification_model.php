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


			$template = 'You have just received '.niara().ptPretyAmount($credit);
			@$this->general_model->agentPush(
				$charge->user,
				'USSD Payment Received',
				$template
			);
		}
	}
}