<?php
class Dashboard_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function getCharts($shop,$time)
	{
		$result = [];
		if($time == "7 days"){
			$dateList = date_range_list(date("Y-m-d", strtotime("-7 days")),date("Y-m-d"));
			foreach($dateList as $key => $date) {
				$servicesSold = $this->db->where('cat >=',$date.' 00:00:00')->where('cat <=',$date.' 24:00:00')->where('provider !=',NULL)->where('shop',$shop)->get('booking')->num_rows();
				$productsSold = $this->db->where('cat >=',$date.' 00:00:00')->where('cat <=',$date.' 24:00:00')->where('provider',NULL)->where('shop',$shop)->get('booking')->result_array();

				$prodSold = 0;
				foreach ($productsSold as $pkey => $pvalue) {
					$prodSoldCount = $this->db->get_where('booking_products',['booking' => $pvalue['id']])->num_rows();
					$prodSold += $prodSoldCount;
				}

				$ar = ['x' => $date,'service' => $servicesSold,'prods' => $prodSold];
				array_push($result, $ar);
			}
		}else if ($time == "1 month") {
			$dateList = date_range_list(date("Y-m-d", strtotime("-1 month")),date("Y-m-d"));
			foreach($dateList as $key => $date) {
				$servicesSold = $this->db->where('cat >=',$date.' 00:00:00')->where('cat <=',$date.' 24:00:00')->where('provider !=',NULL)->where('shop',$shop)->get('booking')->num_rows();
				$productsSold = $this->db->where('cat >=',$date.' 00:00:00')->where('cat <=',$date.' 24:00:00')->where('provider',NULL)->where('shop',$shop)->get('booking')->result_array();

				$prodSold = 0;
				foreach ($productsSold as $pkey => $pvalue) {
					$prodSoldCount = $this->db->get_where('booking_products',['booking' => $pvalue['id']])->num_rows();
					$prodSold += $prodSoldCount;
				}

				$ar = ['x' => $date,'service' => $servicesSold,'prods' => $prodSold];
				array_push($result, $ar);
			}
		}else if ($time == "3 month") {
			$months = [
				['start' => date("Y-m-1", strtotime("-3 month")),'end' => date("Y-m-t", strtotime("-3 month"))],
				['start' => date("Y-m-1", strtotime("-2 month")),'end' => date("Y-m-t", strtotime("-2 month"))],
				['start' => date("Y-m-1", strtotime("-1 month")),'end' => date("Y-m-t", strtotime("-1 month"))]
			];
			foreach($months as $key => $month) {
				$servicesSold = $this->db->where('cat >=',$month['start'])->where('cat <=',$month['end'])->where('provider !=',NULL)->where('shop',$shop)->get('booking')->num_rows();
				$productsSold = $this->db->where('cat >=',$month['start'])->where('cat <=',$month['end'])->where('provider',NULL)->where('shop',$shop)->get('booking')->result_array();

				$prodSold = 0;
				foreach ($productsSold as $pkey => $pvalue) {
					$prodSoldCount = $this->db->get_where('booking_products',['booking' => $pvalue['id']])->num_rows();
					$prodSold += $prodSoldCount;
				}

				$ar = ['x' => date('M',strtotime($month['start'])),'service' => $servicesSold,'prods' => $prodSold];
				array_push($result, $ar);
			}
		}else if ($time == "6 month") {
			$months = [
				['start' => date("Y-m-1", strtotime("-6 month")),'end' => date("Y-m-t", strtotime("-6 month"))],
				['start' => date("Y-m-1", strtotime("-5 month")),'end' => date("Y-m-t", strtotime("-5 month"))],
				['start' => date("Y-m-1", strtotime("-4 month")),'end' => date("Y-m-t", strtotime("-4 month"))],
				['start' => date("Y-m-1", strtotime("-3 month")),'end' => date("Y-m-t", strtotime("-3 month"))],
				['start' => date("Y-m-1", strtotime("-2 month")),'end' => date("Y-m-t", strtotime("-2 month"))],
				['start' => date("Y-m-1", strtotime("-1 month")),'end' => date("Y-m-t", strtotime("-1 month"))]
			];
			foreach($months as $key => $month) {
				$servicesSold = $this->db->where('cat >=',$month['start'])->where('cat <=',$month['end'])->where('provider !=',NULL)->where('shop',$shop)->get('booking')->num_rows();
				$productsSold = $this->db->where('cat >=',$month['start'])->where('cat <=',$month['end'])->where('provider',NULL)->where('shop',$shop)->get('booking')->result_array();

				$prodSold = 0;
				foreach ($productsSold as $pkey => $pvalue) {
					$prodSoldCount = $this->db->get_where('booking_products',['booking' => $pvalue['id']])->num_rows();
					$prodSold += $prodSoldCount;
				}

				$ar = ['x' => date('M',strtotime($month['start'])),'service' => $servicesSold,'prods' => $prodSold];
				array_push($result, $ar);
			}
		}		


		return $result;
	}

	public function getTopCustomers($shop,$time)
	{
		if($time == "7 days"){
			$start = date("Y-m-d", strtotime("-7 days"));
			$end = date("Y-m-d");
			$this->db->where('cat >=', $start);
			$this->db->where('cat <=', $end);
		}else if($time == "1 month"){
			$start = date("Y-m-d", strtotime("-1 month"));
			$end = date("Y-m-d");
			$this->db->where('cat >=', $start);
			$this->db->where('cat <=', $end);
		}else if($time == "3 month"){
			$start = date("Y-m-d", strtotime("-3 month"));
			$end = date("Y-m-d");
			$this->db->where('cat >=', $start);
			$this->db->where('cat <=', $end);
		}else if($time == "6 month"){
			$start = date("Y-m-d", strtotime("-6 month"));
			$end = date("Y-m-d");
			$this->db->where('cat >=', $start);
			$this->db->where('cat <=', $end);
		}
		
		$this->db->distinct();
	    $this->db->select('user');
	    $this->db->where('shop',$shop); 
	    $bookings = $this->db->get('booking')->result_array();
	    $listOfCustomers = [];
	    foreach ($bookings as $key => $value) {
	    	$customerCounter = $this->db->where('user',$value['user'])->where('shop',$shop)->get('booking')->num_rows();
	    	array_push($listOfCustomers, ['user' => $value['user'],'count' => $customerCounter]);
	    }

	    $keys = array_column($listOfCustomers, 'count');
		array_multisort($keys, SORT_DESC, $listOfCustomers);

		$customers = [];
		foreach ($listOfCustomers as $key => $value) {
			if ($key == 3) {
				break;
			}

			$customer = $this->customer_model->getCustomerData($value['user']);
			array_push($customers, $customer);
		}

		return $customers;

	}

	public function getTopServices($shop,$time)
	{
		if($time == "7 days"){
			$start = date("Y-m-d", strtotime("-7 days"));
			$end = date("Y-m-d");
			$this->db->where('cat >=', $start);
			$this->db->where('cat <=', $end);
		}else if($time == "1 month"){
			$start = date("Y-m-d", strtotime("-1 month"));
			$end = date("Y-m-d");
			$this->db->where('cat >=', $start);
			$this->db->where('cat <=', $end);
		}else if($time == "3 month"){
			$start = date("Y-m-d", strtotime("-3 month"));
			$end = date("Y-m-d");
			$this->db->where('cat >=', $start);
			$this->db->where('cat <=', $end);
		}else if($time == "6 month"){
			$start = date("Y-m-d", strtotime("-6 month"));
			$end = date("Y-m-d");
			$this->db->where('cat >=', $start);
			$this->db->where('cat <=', $end);
		}
		$this->db->distinct();
	    $this->db->select('product');
	    $this->db->where('type','service'); 
	    $this->db->where('shop',$shop); 
	    $bookings = $this->db->get('booking_products')->result_array();
	    $listOfProds = [];
	    foreach ($bookings as $key => $value) {
	    	$prodCounter = $this->db->where('product',$value['product'])->get('booking_products')->num_rows();
	    	array_push($listOfProds, ['product' => $value['product'],'count' => $prodCounter]);
	    }

	    $keys = array_column($listOfProds, 'count');
		array_multisort($keys, SORT_DESC, $listOfProds);

		$prods = [];
		foreach ($listOfProds as $key => $value) {
			if ($key == 3) {
				break;
			}

			$prod = $this->shop_model->getProduct($value['product']);
			array_push($prods, $prod);
		}

		return $prods;
	}

	public function getTopProducts($shop,$time)
	{
		if($time == "7 days"){
			$start = date("Y-m-d", strtotime("-7 days"));
			$end = date("Y-m-d");
			$this->db->where('cat >=', $start);
			$this->db->where('cat <=', $end);
		}else if($time == "1 month"){
			$start = date("Y-m-d", strtotime("-1 month"));
			$end = date("Y-m-d");
			$this->db->where('cat >=', $start);
			$this->db->where('cat <=', $end);
		}else if($time == "3 month"){
			$start = date("Y-m-d", strtotime("-3 month"));
			$end = date("Y-m-d");
			$this->db->where('cat >=', $start);
			$this->db->where('cat <=', $end);
		}else if($time == "6 month"){
			$start = date("Y-m-d", strtotime("-6 month"));
			$end = date("Y-m-d");
			$this->db->where('cat >=', $start);
			$this->db->where('cat <=', $end);
		}
		
		$this->db->distinct();
	    $this->db->select('product');
	    $this->db->where('type','product'); 
	    $this->db->where('shop',$shop); 
	    $bookings = $this->db->get('booking_products')->result_array();
	    $listOfProds = [];
	    foreach ($bookings as $key => $value) {
	    	$prodCounter = $this->db->where('product',$value['product'])->get('booking_products')->num_rows();
	    	array_push($listOfProds, ['product' => $value['product'],'count' => $prodCounter]);
	    }

	    $keys = array_column($listOfProds, 'count');
		array_multisort($keys, SORT_DESC, $listOfProds);

		$prods = [];
		foreach ($listOfProds as $key => $value) {
			if ($key == 3) {
				break;
			}

			$prod = $this->shop_model->getProduct($value['product']);
			array_push($prods, $prod);
		}

		return $prods;
	}

	public function getCancelledBookings($shop,$time)
	{
		if($time == "7 days"){
			$start = date("Y-m-d", strtotime("-7 days"));
			$end = date("Y-m-d");
			$this->db->where('cat >=', $start);
			$this->db->where('cat <=', $end);
		}else if($time == "1 month"){
			$start = date("Y-m-d", strtotime("-1 month"));
			$end = date("Y-m-d");
			$this->db->where('cat >=', $start);
			$this->db->where('cat <=', $end);
		}else if($time == "3 month"){
			$start = date("Y-m-d", strtotime("-3 month"));
			$end = date("Y-m-d");
			$this->db->where('cat >=', $start);
			$this->db->where('cat <=', $end);
		}else if($time == "6 month"){
			$start = date("Y-m-d", strtotime("-6 month"));
			$end = date("Y-m-d");
			$this->db->where('cat >=', $start);
			$this->db->where('cat <=', $end);
		}
		$this->db->where('shop', $shop);
		$this->db->where('status', 'cancelled');
		$bookingCount = $this->db->get('booking')->num_rows();
		return number_shorten($bookingCount);
	}

	public function getTotalCustomers($shop,$time)
	{
		if($time == "7 days"){
			$start = date("Y-m-d", strtotime("-7 days"));
			$end = date("Y-m-d");
			$this->db->where('cat >=', $start);
			$this->db->where('cat <=', $end);
		}else if($time == "1 month"){
			$start = date("Y-m-d", strtotime("-1 month"));
			$end = date("Y-m-d");
			$this->db->where('cat >=', $start);
			$this->db->where('cat <=', $end);
		}else if($time == "3 month"){
			$start = date("Y-m-d", strtotime("-3 month"));
			$end = date("Y-m-d");
			$this->db->where('cat >=', $start);
			$this->db->where('cat <=', $end);
		}else if($time == "6 month"){
			$start = date("Y-m-d", strtotime("-6 month"));
			$end = date("Y-m-d");
			$this->db->where('cat >=', $start);
			$this->db->where('cat <=', $end);
		}
		$this->db->where('shop', $shop);
		$this->db->distinct();
    	$this->db->select('user');
		$bookingCount = $this->db->get('booking')->num_rows();
		return number_shorten($bookingCount);
	}

	public function getTotalEarning($shop,$time)
	{
		if($time == "7 days"){
			$start = date("Y-m-d", strtotime("-7 days"));
			$end = date("Y-m-d");
			$this->db->where('cat >=', $start);
			$this->db->where('cat <=', $end);
		}else if($time == "1 month"){
			$start = date("Y-m-d", strtotime("-1 month"));
			$end = date("Y-m-d");
			$this->db->where('cat >=', $start);
			$this->db->where('cat <=', $end);
		}else if($time == "3 month"){
			$start = date("Y-m-d", strtotime("-3 month"));
			$end = date("Y-m-d");
			$this->db->where('cat >=', $start);
			$this->db->where('cat <=', $end);
		}else if($time == "6 month"){
			$start = date("Y-m-d", strtotime("-6 month"));
			$end = date("Y-m-d");
			$this->db->where('cat >=', $start);
			$this->db->where('cat <=', $end);
		}
		$this->db->where('shop', $shop);
		$this->db->where('status', 'completed');
		$this->db->select_sum('total');
		$this->db->from('booking');
		$totalGet = $this->db->get()->row();
		$total = 0.00;
		if($totalGet){
			$total = $totalGet->total;
		}
		return formatTwoDecimal($total);
	}

	public function getProductSold($shop,$time)
	{
		if($time == "7 days"){
			$start = date("Y-m-d", strtotime("-7 days"));
			$end = date("Y-m-d");
			$this->db->where('cat >=', $start);
			$this->db->where('cat <=', $end);
		}else if($time == "1 month"){
			$start = date("Y-m-d", strtotime("-1 month"));
			$end = date("Y-m-d");
			$this->db->where('cat >=', $start);
			$this->db->where('cat <=', $end);
		}else if($time == "3 month"){
			$start = date("Y-m-d", strtotime("-3 month"));
			$end = date("Y-m-d");
			$this->db->where('cat >=', $start);
			$this->db->where('cat <=', $end);
		}else if($time == "6 month"){
			$start = date("Y-m-d", strtotime("-6 month"));
			$end = date("Y-m-d");
			$this->db->where('cat >=', $start);
			$this->db->where('cat <=', $end);
		}
		$this->db->where('shop', $shop);
		$this->db->where('provider', NULL);
		$bookingCount = $this->db->get('booking')->num_rows();
		return number_shorten($bookingCount);
	}

	public function getBookingsByShop($shop,$time)
	{
		if($time == "7 days"){
			$start = date("Y-m-d", strtotime("-7 days"));
			$end = date("Y-m-d");
			$this->db->where('cat >=', $start);
			$this->db->where('cat <=', $end);
		}else if($time == "1 month"){
			$start = date("Y-m-d", strtotime("-1 month"));
			$end = date("Y-m-d");
			$this->db->where('cat >=', $start);
			$this->db->where('cat <=', $end);
		}else if($time == "3 month"){
			$start = date("Y-m-d", strtotime("-3 month"));
			$end = date("Y-m-d");
			$this->db->where('cat >=', $start);
			$this->db->where('cat <=', $end);
		}else if($time == "6 month"){
			$start = date("Y-m-d", strtotime("-6 month"));
			$end = date("Y-m-d");
			$this->db->where('cat >=', $start);
			$this->db->where('cat <=', $end);
		}
		$this->db->where('shop', $shop);
		$bookingCount = $this->db->get('booking')->num_rows();
		return number_shorten($bookingCount);
	}

	public function getBookingPendingCount($provider)
	{
		$this->db->where('provider',$provider);	
		$this->db->where('status','upcoming');	
		return $this->db->get('booking')->num_rows();
	}	

	public function getReviewCount($provider)
	{
		$this->db->where('provider',$provider);	
		return $this->db->get('service_review')->num_rows();
	}

	public function getOverallRating($provider)
	{
		$this->db->where('id',$provider);	
		return $this->db->get('service_provider')->row_array()['rating'];
	}

	public function getBookingCountThisMonth($provider)
	{
		$this->db->where('cat >=', date('Y-m-1'));
		$this->db->where('cat <=', date('Y-m-t'));
		$this->db->where('provider',$provider);	
		return $this->db->get('booking')->num_rows();
	}

	public function getReviewCountThisMonth($provider)
	{
		$this->db->where('cat >=', date('Y-m-1'));
		$this->db->where('cat <=', date('Y-m-t'));
		$this->db->where('provider',$provider);	
		return $this->db->get('service_review')->num_rows();
	}

	public function getThisMonthEarning($provider)
	{
		$this->db->where('cat >=', date('Y-m-1'));
		$this->db->where('cat <=', date('Y-m-t'));
		$this->db->where('provider',$provider);	
		$this->db->where('status','completed');	
		$this->db->select_sum('total');
		$this->db->from('booking');
		$totalGet = $this->db->get()->row();
		$total = 0.00;
		if($totalGet){
			$total = $totalGet->total;
		}
		return formatTwoDecimal($total);
	}
}