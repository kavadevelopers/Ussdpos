<?php
class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function transactions()
	{
		if ($this->input->post('user')) {
			$homeTransactions 	= $this->dashboard_model->getHomeTransactions($this->input->post('user'));
			$data = [
				'_return'		=> true,
				'tracounter'	=> $homeTransactions['count'],
				'tralist'		=> $homeTransactions['list']
			];
			retJson($data);
		}else{
			retJson(['_return' => false,'msg' => '`user` are Required']);
		}
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