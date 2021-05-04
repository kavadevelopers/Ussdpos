<?php
class Chat_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	public function getChat($chat)
	{
		$chatRow = $this->db->get_where('chat',['id' => $chat])->row_array();

		if($chatRow['ftype'] == "customer"){
			$chatRow['f'] = $this->customer_model->getCustomerData($chatRow['f']);
			$chatRow['t'] = $this->service_model->getServiceData($chatRow['t']);
		}else{
			$chatRow['f'] = $this->service_model->getServiceData($chatRow['f']);
			$chatRow['t'] = $this->customer_model->getCustomerData($chatRow['t']);
		}

		if ($chatRow['type'] == "image") {
			$chatRow['descr'] = base_url('uploads/chat/').$chatRow['descr'];
		}
		return $chatRow;
	}


}