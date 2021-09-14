<?php
class Commission_model extends CI_Model
{
	
	function __construct()
	{
		
	}


	public function getUssdComission($amount)
	{
		$com = $this->db->get_where('set_commission',['id','1'])->row_object();

		if ($com->ussd_type == 1) {
			$ret['com']	= $com->ussd_fix;		
		}else{
			$ret['com']	= (($amount * $com->ussd_per) / 100);
		}

		if ($com->fussd_type == 1) {
			$ret['fcom']	= $com->fussd_fix;		
		}else{
			$ret['fcom']	= (($amount * $com->fussd_per) / 100);
		}

		return $ret;
	}
}