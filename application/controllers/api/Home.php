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
			'tracounter'	=> $trans->num_rows(),
			'tralist'		=> $transList
		];

		retJson($data);
	}

	public function get()
	{
		$trans = $this->db->limit(10)->get_where('transactions');
		$transList = $trans->result_object();

		foreach ($transList as $key => $value) {
			$transList[$key]->typestr = ucfirst(traType($value->type)[0]);
		}

		$user = NULL;
		if ($this->input->post('user')) {
			$user = $this->agent_model->get($this->input->post('user'));
		}

		$data = [
			'_return'		=> true,
			'balance'		=> '0.00',
			'pbalance'		=> ptPretyAmount('0.00'),
			'tracounter'	=> $trans->num_rows(),
			'tralist'		=> $transList,
			'user' 			=> $user
		];

		retJson($data);
	}

}