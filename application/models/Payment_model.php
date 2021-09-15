<?php
class Payment_model extends CI_Model
{
	
	public function __construct()
	{
		
	}

	public function ussdCredited($chId)
	{
		@$this->transaction_model->ussdCredited($chId);
		@$this->notification_model->ussdCredited($chId);
	}
}