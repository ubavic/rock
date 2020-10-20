<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\UserModel;

class CanEdit implements FilterInterface
{
	public function before(RequestInterface $request, $arguments = null)
	{
		if(!session()->get('logged'))
			return redirect()->to('/user/login');

		$userModel = new UserModel;
		if(!$userModel->find(session()->get('id'))->can_edit)
			return redirect()->to('/exam');
	}

	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
	
	}
}