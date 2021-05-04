<?php
class Dispute extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function go_to_step4()
	{
		if($this->input->post('booking')){
	    	$data = [
	    		'status'			=> '4'
	    	];
	    	$this->db->where('booking',$this->input->post('booking'))->update('booking_dispute',$data);
	    	retJson(['_return' => true,'msg' => 'Step Changed']);	
		}else{
			retJson(['_return' => false,'msg' => '`booking` are Required']);	
		}
	}

	public function step3()
	{
		if($this->input->post('booking') && $this->input->post('amount') && $this->input->post('description')){

			$config['upload_path'] = './uploads/dispute/';
		    $config['allowed_types']	= '*';
		    $config['max_size']      = '0';
		    $config['overwrite']     = TRUE;
		    $this->load->library('upload', $config);
		    if(isset($_FILES ['file']) && $_FILES['file']['error'] == 0){
		    	$config['file_name'] = microtime(true).".".pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
		    	$this->upload->initialize($config);
		    	if($this->upload->do_upload('file')){
		    		$fileName = $config['file_name'];
		    	}else{
		    		$fileName = "";
		    	}
		    }else{
	    		$fileName = "";
	    	}
	    	$data = [
	    		'status'			=> '4',
	    		'amount3'			=> $this->input->post('amount'),
	    		'description3'		=> $this->input->post('description'),
	    		'evidence_file3'	=> $fileName
	    	];
	    	$this->db->where('booking',$this->input->post('booking'))->update('booking_dispute',$data);
	    	retJson(['_return' => true,'msg' => 'Step Changed']);	

		}else{
			retJson(['_return' => false,'msg' => '`booking`,`amount`,`description` are Required,`file` is optional']);	
		}
	}

	public function step2()
	{
		if($this->input->post('booking') && $this->input->post('amount') && $this->input->post('description')){

			$config['upload_path'] = './uploads/dispute/';
		    $config['allowed_types']	= '*';
		    $config['max_size']      = '0';
		    $config['overwrite']     = TRUE;
		    $this->load->library('upload', $config);
		    if(isset($_FILES ['file']) && $_FILES['file']['error'] == 0){
		    	$config['file_name'] = microtime(true).".".pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
		    	$this->upload->initialize($config);
		    	if($this->upload->do_upload('file')){
		    		$fileName = $config['file_name'];
		    	}else{
		    		$fileName = "";
		    	}
		    }else{
	    		$fileName = "";
	    	}
	    	$data = [
	    		'status'			=> '3',
	    		'amount2'			=> $this->input->post('amount'),
	    		'description2'		=> $this->input->post('description'),
	    		'evidence_file2'	=> $fileName
	    	];
	    	$this->db->where('booking',$this->input->post('booking'))->update('booking_dispute',$data);
	    	retJson(['_return' => true,'msg' => 'Step Changed']);	

		}else{
			retJson(['_return' => false,'msg' => '`booking`,`amount`,`description` are Required,`file` is optional']);	
		}
	}

	public function get_dispute()
	{
		if($this->input->post('booking')){
			$dispute = $this->db->get_where('booking_dispute',['booking' => $this->input->post('booking')])->row_array();
			if($dispute){
				$dispute['booking_ob']	= $this->booking_model->getServiceBooking($this->input->post('booking'));
				retJson(['_return' => true,'data' => $dispute]);	
			}else{
				retJson(['_return' => false,'msg' => 'Dispute not found']);	
			}
		}else{
			retJson(['_return' => false,'msg' => '`booking` are Required']);
		}	
	}

	public function create()
	{
		if($this->input->post('booking') && $this->input->post('user_type') && $this->input->post('dispute_type') && $this->input->post('amount_type') && $this->input->post('amount') && $this->input->post('description')){
			$config['upload_path'] = './uploads/dispute/';
		    $config['allowed_types']	= '*';
		    $config['max_size']      = '0';
		    $config['overwrite']     = TRUE;
		    $this->load->library('upload', $config);
		    if(isset($_FILES ['file']) && $_FILES['file']['error'] == 0){
		    	$config['file_name'] = microtime(true).".".pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
		    	$this->upload->initialize($config);
		    	if($this->upload->do_upload('file')){
		    		$fileName = $config['file_name'];
		    	}else{
		    		$fileName = "";
		    	}
		    }else{
	    		$fileName = "";
	    	}
	    	$data = [
	    		'f'				=> $this->input->post('user_type'),
	    		'booking'		=> $this->input->post('booking'),
	    		'status'		=> '2',
	    		'dispute_type'	=> $this->input->post('dispute_type'),
	    		'amount_type'	=> $this->input->post('amount_type'),
	    		'amount'		=> $this->input->post('amount'),
	    		'description'	=> $this->input->post('description'),
	    		'evidence_file'	=> $fileName,
	    		'cat'			=> _nowDateTime()
	    	];
	    	$this->db->insert('booking_dispute',$data);
	    	retJson(['_return' => true,'msg' => 'Dispute Created']);	
	    }else{
	    	retJson(['_return' => false,'msg' => '`user_type`(customer,provider),`booking`,`dispute_type`,`amount_type`(full,partial),`amount`,`description` are Required,`file` is optional']);	
	    }
	}
}