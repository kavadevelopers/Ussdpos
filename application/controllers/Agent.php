<?php
class Agent extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->auth->check_session();
		$this->rights->redirect([3]);
	}

	public function view($id,$page = "")
	{
		$data['_title']		= "View Agent";	
		$data['page']       = "active";
		if (!empty($page)) {
			$data['page']		= $page;	
		}
		$data['item']		= $this->agent_model->get($id);
		$this->load->theme('appusers/agent/view',$data);
	}

	public function blocked()
	{
		$data['_title']		= "Agents - Blocked/Reported";		
		$this->db->order_by('id','desc');
		$data['list']		= $this->db->get_where('register_agent',['df' => '','block' => 'yes'])->result_object();
		$this->load->theme('appusers/agent/active',$data);	
	}

	public function active()
	{
		$data['_title']		= "Agents - Active";		
		$this->db->order_by('id','desc');
		$data['list']		= $this->db->get_where('register_agent',['df' => '','block' => ''])->result_object();
		$this->load->theme('appusers/agent/active',$data);	
	}

	public function delete($id,$type)
	{
		$this->db->where('id',$id)->update('register_agent',['df' => 'yes']);
		$this->session->set_flashdata('msg', 'Agent deleted');
	    redirect(base_url('agent/'.$type));
	}

	public function block($id,$type,$status = false)
	{
		$s = "";
		if($status){ $s = "yes"; }
		$this->db->where('id',$id)->update('register_agent',['block' => $s]);
		$this->session->set_flashdata('msg', 'Status Changed');
	    redirect(base_url('agent/'.$type));
	}
}