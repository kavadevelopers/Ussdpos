<?php
class Products extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->auth->check_session();
	}

	public function list()
	{
		$data['_title']		= "Manage Products";	
		$data['list']		= $this->db->get_where('products',['df' => ''])->result_object();
		$this->load->theme('products/list',$data);
	}

	public function add()
	{
		$data['_title']		= "Add Product";	
		$this->load->theme('products/add',$data);
	}

	public function edit($id)
	{
		$data['_title']		= "Edit Product";	
		$data['item']		= $this->db->get_where('products',['id' => $id])->row_object();
		$this->load->theme('products/edit',$data);	
	}

	public function delete($id)
	{
		$old = $this->db->get_where('products',['id' => $id])->row_array();
		if(file_exists(FCPATH.'/uploads/products/'.$old['image'])){
			@unlink(FCPATH.'/uploads/products/'.$old['image']);
		}
		$this->db->where('id',$id)->update('products',['df' => 'yes']);
		$this->session->set_flashdata('msg', 'Product Deleted');
		redirect(base_url('products/list'));
	}

	public function update()
	{
		$config['upload_path'] = './uploads/products/';
	    $config['allowed_types']	= '*';
	    $config['max_size']      = '0';
	    $config['overwrite']     = FALSE;
	    $file_name = "";

	    $this->load->library('upload', $config);
	    if (isset($_FILES ['image']) && $_FILES ['image']['error'] == 0) {
			$file_name = microtime(true).".".pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
			$config['file_name'] = $file_name;
	    	$this->upload->initialize($config);
	    	if($this->upload->do_upload('image')){
	    		$old = $this->db->get_where('products',['id' => $this->input->post('id')])->row_array();
	    		if(file_exists(FCPATH.'/uploads/products/'.$old['image'])){
	    			@unlink(FCPATH.'/uploads/products/'.$old['image']);
	    		}
	    		$data = [
					'image'		=> $file_name
				];
				$this->db->where('id',$this->input->post('id'))->update('products',$data);
	    	}
		}

		$data = [
			'name'					=> $this->input->post('name'),
			'category'				=> $this->input->post('category'),
			'price'					=> $this->input->post('price'),
			'leasefee'				=> $this->input->post('leasefee'),
			'leasemonth'			=> $this->input->post('leasemonth'),
			'provider'				=> $this->input->post('provider'),
			'with_rate'				=> $this->input->post('with_rate'),
			'depo_rate'				=> $this->input->post('depo_rate'),
			'target_type'			=> $this->input->post('target_type'),
			'target_duration'		=> $this->input->post('target_duration'),
			'target_amount'			=> $this->input->post('target_amount'),
			'descr'					=> $this->input->post('content')
		];
		$this->db->where('id',$this->input->post('id'))->update('products',$data);
		$this->session->set_flashdata('msg', 'Product Saved');
		redirect(base_url('products/list'));
	}

	public function save()
	{

		$config['upload_path'] = './uploads/products/';
	    $config['allowed_types']	= '*';
	    $config['max_size']      = '0';
	    $config['overwrite']     = FALSE;
	    $file_name = "";

	    $this->load->library('upload', $config);
	    if (isset($_FILES ['image']) && $_FILES ['image']['error'] == 0) {
			$file_name = microtime(true).".".pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
			$config['file_name'] = $file_name;
	    	$this->upload->initialize($config);
	    	if($this->upload->do_upload('image')){
	    		
	    	}else{
	    		$file_name = "";
	    	}
		}

		$data = [
			'image'					=> $file_name,
			'name'					=> $this->input->post('name'),
			'category'				=> $this->input->post('category'),
			'price'					=> $this->input->post('price'),
			'leasefee'				=> $this->input->post('leasefee'),
			'leasemonth'			=> $this->input->post('leasemonth'),
			'provider'				=> $this->input->post('provider'),
			'with_rate'				=> $this->input->post('with_rate'),
			'depo_rate'				=> $this->input->post('depo_rate'),
			'target_type'			=> $this->input->post('target_type'),
			'target_duration'		=> $this->input->post('target_duration'),
			'target_amount'			=> $this->input->post('target_amount'),
			'descr'					=> $this->input->post('content'),
			'df'					=> "",
			'cat'					=> _nowDateTime()
		];


		$this->db->insert('products',$data);

		$this->session->set_flashdata('msg', 'Product Added');
		redirect(base_url('products/list'));
	}

	public function categories()
	{
		$data['_title']		= "Manage Categories";
		$data['list']	= $this->db->get_where('products_cate',['df' => ''])->result_array();
		$data['_e']		= "0";
		$this->load->theme('products/categories',$data);
	}

	public function edit_category($id)
	{
		$data['_title']		= "Manage Categories";
		$data['list']	= $this->db->get_where('products_cate',['df' => ''])->result_array();
		$data['item']	= $this->db->get_where('products_cate',['id' => $id])->row_object();
		$data['_e']		= "1";
		$this->load->theme('products/categories',$data);
	}

	public function delete_categories($id)
	{
		$this->db->where('id',$id)->update('products_cate',['df' => 'yes']);
		$this->session->set_flashdata('msg', 'Category Deleted');
		redirect(base_url('products/categories'));
	}

	public function update_category()
	{
		$config['upload_path'] = './uploads/products/';
	    $config['allowed_types']	= '*';
	    $config['max_size']      = '0';
	    $config['overwrite']     = FALSE;
	    $file_name = "";

	    $this->load->library('upload', $config);
	    if (isset($_FILES ['image']) && $_FILES ['image']['error'] == 0) {
			$file_name = microtime(true).".".pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
			$config['file_name'] = $file_name;
	    	$this->upload->initialize($config);
	    	if($this->upload->do_upload('image')){
	    		$old = $this->db->get_where('products_cate',['id' => $this->input->post('id')])->row_array();
	    		if(file_exists(FCPATH.'/uploads/products/'.$old['image'])){
	    			@unlink(FCPATH.'/uploads/products/'.$old['image']);
	    		}
	    		$data = [
					'image'		=> $file_name
				];
				$this->db->where('id',$this->input->post('id'))->update('products_cate',$data);
	    	}
		}

		$data = [
			'name'		=> $this->input->post('name')
		];
		$this->db->where('id',$this->input->post('id'))->update('products_cate',$data);

		$this->session->set_flashdata('msg', 'Category Saved');
		redirect(base_url('products/categories'));
	}

	public function save_category()
	{
		$config['upload_path'] = './uploads/products/';
	    $config['allowed_types']	= '*';
	    $config['max_size']      = '0';
	    $config['overwrite']     = FALSE;
	    $file_name = "";

	    $this->load->library('upload', $config);
	    if (isset($_FILES ['image']) && $_FILES ['image']['error'] == 0) {
			$file_name = microtime(true).".".pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
			$config['file_name'] = $file_name;
	    	$this->upload->initialize($config);
	    	if($this->upload->do_upload('image')){
	    		
	    	}else{
	    		$file_name = "";
	    	}
		}

		$data = [
			'name'		=> $this->input->post('name'),
			'image'		=> $file_name,
			'df'		=> ''
		];
		$this->db->insert('products_cate',$data);

		$this->session->set_flashdata('msg', 'Category Added');
		redirect(base_url('products/categories'));
	}
}