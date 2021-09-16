<?php
class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function transactions()
	{
		$trans = $this->db->limit(10)->get_where('transactions');	
		$transList = $trans->result_object();
		foreach ($transList as $key => $value) {
			$transList[$key]->typestr = ucfirst(traType($value->type)[0]);
		}

		$data = [
			'_return'		=> true,
			'tracounter'	=> 0,
			'tralist'		=> $transList
		];

		retJson($data);
	}

	public function get()
	{
		if ($this->input->post('user')) {
			$user = $this->agent_model->get($this->input->post('user'));



			$balance 			= $this->dashboard_model->getAgentBalance($this->input->post('user'));
			$homeTransactions 	= $this->dashboard_model->getHomeTransactions($this->input->post('user'));
			$data = [
				'_return'		=> true,
				'balance'		=> formatTwoDecimal($balance),
				'pbalance'		=> ptPretyAmount($balance),
				'tracounter'	=> $homeTransactions['count'],
				'tralist'		=> $homeTransactions['list'],
				'user' 			=> $user
			];
			retJson($data);
		}else{
			retJson(['_return' => false,'msg' => '`user` are Required']);
		}
	}

}