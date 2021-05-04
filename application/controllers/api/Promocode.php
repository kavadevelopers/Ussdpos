<?php
class Promocode extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function modify_product_discount()
	{
		if($this->input->post('product_discount_id') && $this->input->post('user') && $this->input->post('service') && $this->input->post('shop') && $this->input->post('percentage') && $this->input->post('prods')){	

			$data = [
				'service'			=> $this->input->post('service'),
				'shop'				=> $this->input->post('shop'),
				'percentage'		=> $this->input->post('percentage'),
				'prods'				=> $this->input->post('prods'),
				'cby'				=> $this->input->post('user')
			];
			$this->db->where('id',$this->input->post('product_discount_id'))->update('promo_prods',$data);
			retJson(['_return' => true,'msg' => 'Product Discount Updated']);

		}else{
			retJson(['_return' => false,'msg' => '`product_discount_id`,`user`,`service`,`shop`,`percentage`,`prods` are Required']);
		}
	}

	public function delete_product_discount()
	{
		if($this->input->post('product_discount_id')){
			$this->db->where('id',$this->input->post('product_discount_id'))->update('promo_prods',['df' => 'yes']);
			retJson(['_return' => true,'msg' => 'Product Discount Deleted']);
		}else{
			retJson(['_return' => false,'msg' => '`product_discount_id` are Required']);
		}	
	}

	public function list_product_discount()
	{
		if($this->input->post('service')){
			$list = $this->db->order_by('id','desc')->get_where('promo_prods',['service' => $this->input->post('service'),'df' => ''])->result_array();
			retJson(['_return' => true,'list' => $list]);
		}else{
			retJson(['_return' => false,'msg' => '`service` are Required']);
		}
	}

	public function create_product_discount()
	{
		if($this->input->post('user') && $this->input->post('service') && $this->input->post('shop') && $this->input->post('percentage') && $this->input->post('prods')){	

			$data = [
				'service'			=> $this->input->post('service'),
				'shop'				=> $this->input->post('shop'),
				'percentage'		=> $this->input->post('percentage'),
				'prods'				=> $this->input->post('prods'),
				'cby'				=> $this->input->post('user'),
				'df'				=> '',
				'cat'				=> _nowDateTime()
			];
			$this->db->insert('promo_prods',$data);
			retJson(['_return' => true,'msg' => 'Product Discount Created']);

		}else{
			retJson(['_return' => false,'msg' => '`user`,`service`,`shop`,`percentage`,`prods` are Required']);
		}
	}

	public function delete()
	{
		if($this->input->post('promoid')){
			$this->db->where('id',$this->input->post('promoid'))->update('promocodes',['df' => 'yes']);
			retJson(['_return' => true,'msg' => 'Promocode Deleted']);
		}else{
			retJson(['_return' => false,'msg' => '`promoid` are Required']);
		}	
	}

	public function modify()
	{
		if($this->input->post('user') && $this->input->post('service') && $this->input->post('shop') && $this->input->post('promo') && $this->input->post('descr') && $this->input->post('discount_type') && $this->input->post('amount') && $this->input->post('universal') && $this->input->post('active') && $this->input->post('promoid')){
			if(!$this->db->get_where('promocodes',['promo' => $this->input->post('promo'),'id !=' => $this->input->post('promoid')])->row_array()){
				$limit = "";
				if($this->input->post('limit')){
					$limit = $this->input->post('limit');
				}

				$data = [
					'shop'				=> $this->input->post('shop'),
					'service'			=> $this->input->post('service'),
					'promo'				=> strtoupper($this->input->post('promo')),
					'descr'				=> $this->input->post('descr'),
					'discount_type'		=> $this->input->post('discount_type'),
					'amount'			=> $this->input->post('amount'),
					'ulimit'			=> $limit,
					'universal'			=> $this->input->post('universal'),
					'active'			=> $this->input->post('active'),
					'df'				=> '',
					'cby'				=> $this->input->post('user')
				];
				$this->db->where('id',$this->input->post('promoid'))->update('promocodes',$data);
				retJson(['_return' => true,'msg' => 'Promocode Updated']);
			}else{
				retJson(['_return' => false,'msg' => 'Promocode already exists.']);
			}
		}else{	
			retJson(['_return' => false,'msg' => '`promoid`,`user`,`shop`,`service`,`promo`,`descr`,`discount_type`(customer,member,both),`amount`,`universal`,`active` are Required,`limit`(if not unlimited add limit like 100,300,350) are optional']);
		}
	}

	public function list()
	{
		if($this->input->post('service')){
			$list = $this->db->order_by('id','desc')->get_where('promocodes',['service' => $this->input->post('service'),'df' => ''])->result_array();
			retJson(['_return' => true,'list' => $list]);
		}else{
			retJson(['_return' => false,'msg' => '`service` are Required']);
		}
	}

	public function create()
	{
		if($this->input->post('user') && $this->input->post('service') && $this->input->post('shop') && $this->input->post('promo') && $this->input->post('descr') && $this->input->post('discount_type') && $this->input->post('amount') && $this->input->post('universal') && $this->input->post('active')){
			if(!$this->db->get_where('promocodes',['promo' => $this->input->post('promo')])->row_array()){
				$limit = "";
				if($this->input->post('limit')){
					$limit = $this->input->post('limit');
				}

				$data = [
					'shop'				=> $this->input->post('shop'),
					'service'			=> $this->input->post('service'),
					'promo'				=> strtoupper($this->input->post('promo')),
					'descr'				=> $this->input->post('descr'),
					'discount_type'		=> $this->input->post('discount_type'),
					'amount'			=> $this->input->post('amount'),
					'ulimit'			=> $limit,
					'universal'			=> $this->input->post('universal'),
					'active'			=> $this->input->post('active'),
					'df'				=> '',
					'cby'				=> $this->input->post('user'),
					'cat'				=> _nowDateTime()
				];
				$this->db->insert('promocodes',$data);
				retJson(['_return' => true,'msg' => 'Promocode Added']);
			}else{
				retJson(['_return' => false,'msg' => 'Promocode already exists.']);
			}

		}else{	
			retJson(['_return' => false,'msg' => '`user`,`shop`,`service`,`promo`,`descr`,`discount_type`(customer,member,both),`amount`,`universal`,`active` are Required,`limit`(if not unlimited add limit like 100,300,350) are optional']);
		}
	}
}