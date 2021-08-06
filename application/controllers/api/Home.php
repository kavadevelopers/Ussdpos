<?php
class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get()
	{
		$data = [
			'_return'		=> true,
			'balance'		=> '18500.00',
			'pbalance'		=> ptPretyAmount('18500.00')
		];

		retJson($data);
	}

}