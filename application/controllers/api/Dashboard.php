<?php
class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_dashboard()
	{
		if($this->input->post('user') && $this->input->post('time_period') && $this->input->post('shop')) {
			
			$data = [
				'graph'				=> $this->dashboard_model->getCharts($this->input->post('shop'),$this->input->post('time_period')),
				'booking_count'	=> $this->dashboard_model->getBookingsByShop($this->input->post('shop'),$this->input->post('time_period')),
				'product_sold_count'	=> $this->dashboard_model->getProductSold($this->input->post('shop'),$this->input->post('time_period')),
				'total_earning'	=> $this->dashboard_model->getTotalEarning($this->input->post('shop'),$this->input->post('time_period')),
				'total_customers'	=> $this->dashboard_model->getTotalCustomers($this->input->post('shop'),$this->input->post('time_period')),
				'cancellation_rate'	=> $this->dashboard_model->getCancelledBookings($this->input->post('shop'),$this->input->post('time_period')),
				'top_products'		=> $this->dashboard_model->getTopProducts($this->input->post('shop'),$this->input->post('time_period')),
				'top_services'		=> $this->dashboard_model->getTopServices($this->input->post('shop'),$this->input->post('time_period')),
				'top_customers'		=> $this->dashboard_model->getTopCustomers($this->input->post('shop'),$this->input->post('time_period'))
			];
			retJson(['_return' => true,'data' => $data]);
		}else{
			retJson(['_return' => false,'msg' => '`user`,`shop`,`time_period`(all,7 days,1 month.3 month,6 month) are Required']);
		}
	}

	public function get_home()
	{
		if ($this->input->post('user')) {
			$data = [
				'earning'			=> $this->dashboard_model->getThisMonthEarning($this->input->post('user')),
				'review_thismonth'	=> $this->dashboard_model->getReviewCountThisMonth($this->input->post('user')),
				'booking_thismonth'	=> $this->dashboard_model->getBookingCountThisMonth($this->input->post('user')),
				'overall_rating'	=> $this->dashboard_model->getOverallRating($this->input->post('user')),
				'review_total'		=> $this->dashboard_model->getReviewCount($this->input->post('user')),
				'pending_bookings'	=> $this->dashboard_model->getBookingPendingCount($this->input->post('user'))
			];	
			retJson(['_return' => true,'data' => $data]);
		}else{
			retJson(['_return' => false,'msg' => '`user` are Required']);
		}
	}
}