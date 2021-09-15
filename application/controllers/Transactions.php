<?php
class Transactions extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->auth->check_session();
		$this->rights->redirect([5]);
	}

	public function agent()
	{
		$data['_title']		= "Agent Transactions";		
		$this->db->order_by('id','desc');
		if ($this->input->post('limit')) {
			if ($this->input->post('limit') != "All") {
				$this->db->limit($this->input->post('limit'));	
			}
		}else{
			$this->db->limit(100);	
		}
		if ($this->input->post('perticulars')) {
			$this->db->where('type',$this->input->post('perticulars'));	
		}
		if ($this->input->post('user')) {
			$this->db->where('user',$this->input->post('user'));	
		}
		if ($this->input->post('from')) {
			$this->db->where('dt >=',dd($this->input->post('from')));	
		}
		if ($this->input->post('to')) {
			$this->db->where('dt <=',dd($this->input->post('to')));	
		}
		if ($this->input->post('tradebcre') && $this->input->post('tradebcre') != "Both") {
			if ($this->input->post('tradebcre') == "Credit") {
				$this->db->where('credit !=',0.00);			
			}
			if ($this->input->post('tradebcre') == "Debit") {
				$this->db->where('debit !=',0.00);			
			}
		}
		$this->db->where('usertype','agent');
		$data['list']		= $this->db->get('transactions')->result_object();
		$this->load->theme('transactions/agent',$data);	
	}

	public function ussd()
	{
		$data['_title']		= "UssdPos Transactions";		
		$this->db->order_by('id','desc');
		if ($this->input->post('limit')) {
			if ($this->input->post('limit') != "All") {
				$this->db->limit($this->input->post('limit'));	
			}
		}else{
			$this->db->limit(100);	
		}
		if ($this->input->post('perticulars')) {
			$this->db->where('type',$this->input->post('perticulars'));	
		}
		if ($this->input->post('user')) {
			$this->db->where('user',$this->input->post('user'));	
		}
		if ($this->input->post('from')) {
			$this->db->where('dt >=',dd($this->input->post('from')));	
		}
		if ($this->input->post('to')) {
			$this->db->where('dt <=',dd($this->input->post('to')));	
		}
		if ($this->input->post('tradebcre') && $this->input->post('tradebcre') != "Both") {
			if ($this->input->post('tradebcre') == "Credit") {
				$this->db->where('credit !=',0.00);			
			}
			if ($this->input->post('tradebcre') == "Debit") {
				$this->db->where('debit !=',0.00);			
			}
		}
		$this->db->where('usertype','admin');
		$data['list']		= $this->db->get('transactions')->result_object();
		$this->load->theme('transactions/agent',$data);	
	}
}