<?php namespace App\Controllers;

class About extends BaseController
{
	public function index()
	{
		$data['TITLE'] = "О пројекту";
		echo view('template/header', $data);
		echo view('pages/about');
		echo view('template/footer');
	}
}
