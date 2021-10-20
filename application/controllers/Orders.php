<?php
class Orders extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->auth->check_session();
		$this->rights->redirect([6]);
	}


	public function list()
	{
		$data['_title']		= "POS Orders";
		$this->db->order_by('id','desc');
		$data['list']		= $this->db->get('orders')->result_object();
		$this->load->theme('orders/list',$data);	
	}

	public function view($id)
	{
		$data['_title']		= "POS Orders";
		$data['item']		= $this->db->get_where('orders',['id' => $id])->row_object();
		$this->load->theme('orders/view',$data);	
	}

	public function change_status()
	{
		if ($this->input->post('status') == "8") {
			$order		= $this->db->get_where('orders',['id' => $this->input->post('id')])->row_object();
			@$this->transaction_model->posOrderRefund($order->user,$order->total,$this->input->post('id'));
		}
		$this->db->where('id',$this->input->post('id'))->update('orders',['status' => $this->input->post('status'),'note' => $this->input->post('note')]);
		$this->session->set_flashdata('msg', 'Status Changed');
	    redirect(base_url('orders/list'));
	}

	public function get()
	{
		$order = $this->db->get_where('orders',['id' => $this->input->post('id')])->row_object();
		$product = $this->db->get_where('products',['id' => $order->product])->row_object(); 
		$data = "";
		$data .= '<div class="modal-dialog modal-lg">';
			$data .= '<div class="modal-content">';
				$data .= '<div class="modal-header">';
					$data .= '<h5 class="modal-title" id="">Order #'.$order->ordid.'</h5>';
					$data .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
						$data .= '<span aria-hidden="true">&times;</span>';
					$data .= '</button>';
				$data .= '</div>';
				$data .= '<div class="modal-body">';
					$data .= '<div class="row">';
						$data .= '<div class="col-lg-12">';
							$data .= '<div class="general-info">';
								$data .= '<div class="row">';
									$data .= '<div class="col-lg-12 col-xl-6">';
										$data .= '<div class="table-responsive">';
											$data .= '<table class="table m-0 tbl-white-normal">';
												$data .= '<tbody>';
													$data .= '<tr>';
														$data .= '<th scope="row">Purchase Option</th>';
														$data .= '<td>'.posPurchaseOption($order->poption).'</td>';
													$data .= '</tr>';
													$data .= '<tr>';
														$data .= '<th scope="row">POS Device</th>';
														$data .= '<td>'.$product->name.'</td>';
													$data .= '</tr>';
													$data .= '<tr>';
														$data .= '<th scope="row">Delivery Type</th>';
														$data .= '<td>'.deliveryType($order->deliverytype).'</td>';
													$data .= '</tr>';
													$data .= '<tr>';
														$data .= '<th scope="row">State</th>';
														$data .= '<td>'.$order->state.'</td>';
													$data .= '</tr>';
													if($order->deliverytype == 1){ 
														$data .= '<tr>';
															$data .= '<th scope="row">Terminal Location</th>';
															$data .= '<td>'.$order->terminal.'</td>';
														$data .= '</tr>';
													}
													if($order->deliverytype == 2){ 
														$data .= '<tr>';
															$data .= '<th scope="row">Delivery Address</th>';
															$data .= '<td>'.$order->terminal.'</td>';
														$data .= '</tr>';
														$data .= '<tr>';
															$data .= '<th scope="row">Closest Bus Park</th>';
															$data .= '<td>'.$order->buspark.'</td>';
														$data .= '</tr>';
													}
													$data .= '<tr>';
														$data .= '<th scope="row">Type</th>';
														$data .= '<td>'.$order->paymenttype.'</td>';
													$data .= '</tr>';
													$data .= '<tr>';
														$data .= '<th scope="row">Price</th>';
														$data .= '<td>'.niara().ptPretyAmount($order->price).' x '.$order->qty .' nos.</td>';
													$data .= '</tr>';
													$data .= '<tr>';
														$data .= '<th scope="row">Subtotal</th>';
														$data .= '<td>'.niara().ptPretyAmount($order->subtotal).'</td>';
													$data .= '</tr>';
													$data .= '<tr>';
														$data .= '<th scope="row">Delivery</th>';
														$data .= '<td>'.niara().ptPretyAmount($order->delivery).'</td>';
													$data .= '</tr>';
													$data .= '<tr>';
														$data .= '<th scope="row">Total Paid</th>';
														$data .= '<td>'.niara().ptPretyAmount($order->total).'</td>';
													$data .= '</tr>';
												$data .= '</tbody>';
											$data .= '</table>';
										$data .= '</div>';
									$data .= '</div>';
									$data .= '<div class="col-lg-12 col-xl-6">';
										$data .= '<div class="table-responsive">';
											$data .= '<table class="table m-0 tbl-white-normal">';
												$data .= '<tbody>';
													$data .= '<tr>';
														$data .= '<th scope="row">Order Status</th>';
														$data .= '<td>'.getStatusString($order->status).'</td>';
													$data .= '</tr>';
													$data .= '<tr>';
														$data .= '<th scope="row">Ordered At</th>';
														$data .= '<td>'.getPretyDateTime($order->cat).'</td>';
													$data .= '</tr>';
													$data .= '<tr>';
														$data .= '<th scope="row">Agent</th>';
														$data .= '<td>'.$this->agent_model->getSomeInfo($order->user)->name.'</td>';
													$data .= '</tr>';
													$data .= '<tr>';
														$data .= '<th scope="row">Email</th>';
														$data .= '<td>'.$this->agent_model->getSomeInfo($order->user)->email.'</td>';
													$data .= '</tr>';
													$data .= '<tr>';
														$data .= '<th scope="row">Mobile no.</th>';
														$data .= '<td>'.$this->agent_model->getSomeInfo($order->user)->phone.'<a href="https://web.whatsapp.com/send?phone=+234'.$this->agent_model->getSomeInfo($order->user)->phone.'" target="_blank">
                                                                            <img src="'.base_url("asset/images/watsapp.png").'" style="width:20px;">
                                                                        </a></td>';
													$data .= '</tr>';
													$data .= '<tr>';
														$data .= '<th scope="row">Account Status</th>';
														$data .= '<td>'.agentAcStatus($this->agent_model->getSomeInfo($order->user)->status).'</td>';
													$data .= '</tr>';
												$data .= '</tbody>';
											$data .= '</table>';
										$data .= '</div>';
									$data .= '</div>';
								$data .= '</div>';
							$data .= '</div>';
						$data .= '</div>';
					$data .= '</div>';
				$data .= '</div>';
			$data .= '</div>';
		$data .= '</div>';

		retJson(['_return' => true,'bodyR' => $data]);
	}
}