<?php
class Dashboard_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function getActiveAgents()
	{
		$this->db->where('df','');
		$this->db->where('status','1');
		return $this->db->get('register_agent')->num_rows();
	}

	public function getLatest50Transaction()
	{
		$this->db->limit(50);
		$this->db->order_by('id','desc');
		$this->db->where('usertype','admin');	
		$q = $this->db->get('transactions');
		return $q->result_object();
	}

	public function getAllTransactions($user)
	{
		$this->db->order_by('id','desc');
		$this->db->where('usertype','agent');
		$this->db->where('user',$user);
		$q = $this->db->get('transactions');
		$list = $q->result_object();
		foreach ($list as $key => $value) {
			if ($value->type == '1') {
				$list[$key]->title 		= "USSD Payment";
				$list[$key]->desc 		= "Payment Received";
				$list[$key]->at 		= getPretyDate($value->dt);
				$list[$key]->debit 		= ptPretyAmount($value->debit);
				$list[$key]->credit 	= ptPretyAmount($value->credit);
			}
		}
		return ['count' => $q->num_rows(),'list' => $list];
	}

	public function getHomeTransactions($user)
	{
		$this->db->limit(10);
		$this->db->order_by('id','desc');
		$this->db->where('usertype','agent');
		$this->db->where('user',$user);
		$q = $this->db->get('transactions');
		$list = $q->result_object();
		foreach ($list as $key => $value) {
			if ($value->type == '1') {
				$list[$key]->title 		= "USSD Payment";
				$list[$key]->desc 		= "Payment Received";
				$list[$key]->at 		= getPretyDate($value->dt);
				$list[$key]->debit 		= ptPretyAmount($value->debit);
				$list[$key]->credit 	= ptPretyAmount($value->credit);
			}
		}
		return ['count' => $q->num_rows(),'list' => $list];
	}

	public function getAgentBalance($user)
	{
		$this->db->select_sum('debit');
		$this->db->where('usertype','agent');
		$this->db->where('user',$user);
		$debit = $this->db->get('transactions')->row_object();
		$debitA = 0;
		if ($debit) {
			$debitA = $debit->debit;
		}

		$this->db->select_sum('credit');
		$this->db->where('usertype','agent');
		$this->db->where('user',$user);
		$credit = $this->db->get('transactions')->row_object();
		$creditA = 0;
		if ($credit) {
			$creditA = $credit->credit;
		}

		return $creditA - $debitA;
	}

	public function getAdminBalance()
	{
		$this->db->select_sum('debit');
		$debit = $this->db->get('transactions')->row_object();
		$debitA = 0;
		if ($debit) {
			$debitA = $debit->debit;
		}

		$this->db->select_sum('credit');
		$credit = $this->db->get('transactions')->row_object();
		$creditA = 0;
		if ($credit) {
			$creditA = $credit->credit;
		}

		return $creditA - $debitA;
	}

	public function getAdminUssdCollected()
	{
		$this->db->select_sum('credit');
		$this->db->where('type',traType(1)[1]);
		$credit = $this->db->get('transactions')->row_object();
		$creditA = 0;
		if ($credit) {
			$creditA = $credit->credit;
		}

		return $creditA;
	}

	public function getAdminFeesCollected()
	{
		$this->db->select_sum('credit');
		$this->db->where('type',traType(2)[1]);
		$credit = $this->db->get('transactions')->row_object();
		$creditA = 0;
		if ($credit) {
			$creditA = $credit->credit;
		}

		return $creditA;
	}
}