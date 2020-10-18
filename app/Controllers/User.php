<?php namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ExamModel;
use App\Models\LogModel;

class User extends BaseController
{

	private $errors = [
		'name' => [
			'required' => 'Име је обавезно',
			'min_length' => 'Име мора да садржи барем 3 карактера.',
			'max_length' => 'Име може да садржи највише 255 карактера.'
		],
		'email' => [
			'required' => 'E-mail је обавезан.',
			'valid_email' => 'E-mail мора бити валидан.',
			'is_unique' => 'Унети е-mail је већ искоришћен за регистарцију налога.',
		],
		'password' => [
			'required' => 'Шифра је обавезна.',
			'min_length' => 'Шифра мора имати најмање осам карактера.',
			'max_length' => 'Шифра може имати највише 255 карактера.',
			'validateUser' => "Email и/или шифра нису тачни."
		],
		'pass_confirm' => [
			'required_with' => 'Морате поновити шифру.',
			'matches' => 'Шифре морају бити исте.'
		]
	];

	public function index()
	{
		return redirect()->to('/user/login');
	}
	
	public function login()
	{
		$data['TITLE'] = "Пријавите се";
		helper(['form']);

		if($this->request->getMethod() == 'post') {
			$logModel = new LogModel();
			$rules = [
				'email'        => 'required|valid_email',
				'password'     => 'required|validateUser[email,password]'
			];

			if ($this->validate($rules, $this->errors)) {
				$loginData = [
					'email' => $this->request->getVar('email'),
					'password' => $this->request->getVar('password'),
				];
				
				$userModel = new UserModel();
				$user = $userModel->where('email', $this->request->getVar('email'))->first();
				$this->setUser($user);

				$logModel->save([
					'user' => $user->id,
					'ip' => $this->request->getIPAddress(),
				]);

				return redirect()->to('/');
			} else {
				$logModel->save([
					'user' => NULL,
					'ip' => $this->request->getIPAddress(),
				]);

				$data['validation'] = $this->validator;
				echo view('template/header', $data);
				echo view('user/login');
				echo view('template/footer');
			}
		} else {
			echo view('template/header', $data);
			echo view('user/login');
			echo view('template/footer');
		}
	}

	public function register()
	{
		$data['TITLE'] = "Региструјте се";
		helper(['form']);

		if($this->request->getMethod() == 'post') {
			$rules = [
				'email'        => 'required|valid_email|is_unique[users.email]',
				'password'     => 'required|min_length[8]|max_length[255]',
				'pass_confirm' => 'required_with[password]|matches[password]',
			];

			if ($this->validate($rules, $this->errors)) {
				$regData = [
					'name' => $this->request->getVar('email'),
					'email' => $this->request->getVar('email'),
					'hash' => $this->request->getVar('password'),
					'status' => 0,
					'permission' => 0
				];

				$userModel = new UserModel();
				$userModel->save($regData);
				session()->setFlashdata('success', 'Регистрација је успешно обављена!');

				return redirect()->to('/user/login');
			} else {
				$data['validation'] = $this->validator;
				echo view('template/header', $data);
				echo view('user/register');
				echo view('template/footer');
			}
		} else {
			echo view('template/header', $data);
			echo view('user/register');
			echo view('template/footer'); 
		}
	}

	public function controlpanel(){
		$data['TITLE'] = "Кориснички контролни панел";
		helper(['form']);

		$userModel = new UserModel();

		$examModel = new ExamModel();
		$data["createdExams"] = $examModel->where('created_by', session()->get('id'))->findAll();

		if ($this->request->getMethod() == 'post') {
			if ($this->request->getPost("name")) {
				$rules = [
					'name' => 'required|min_length[3]|max_length[255]',
				];

				if ($this->validate($rules, $this->errors)) {
					$userModel->save([
						'id' => session()->get('id'),
						'name' => $this->request->getVar('name'),
					]);
					session()->set('name', $this->request->getVar('name'));
					session()->setFlashdata('success', 'Име је успешно промењено.');
				} else {
					$data['validation'] = $this->validator;
				}
			} else if ($this->request->getPost("password")) {
				$rules = [
					'password'     => 'required|min_length[8]|max_length[255]',
					'pass_confirm' => 'required_with[password]|matches[password]',
				];
		
				if ($this->validate($rules, $this->errors)) {
					$userModel->save([
						'id' => session()->get('id'),
						'hash' => $this->request->getVar('password'),
					]);
					session()->setFlashdata('success', 'Шифра је успешно промењена.');
				} else {
					$data['validation'] = $this->validator;
				}
			}
		}

		$user = $userModel->find(session()->get('id'));
		$data["name"] = $user->name;
		$data["email"] = $user->email;

		echo view('template/header', $data);
		echo view('user/controlPanel');
		echo view('template/footer'); 
	}

	private function setUser($user) {
		$data = [
			'id' => $user->id,
			'name' => $user->name,
			'logged' => true
		];

		session()->set($data);
		return true;
	}

	public function logout () {
		session()->destroy();
		return redirect()->to('/');
	}

	public function terms(){
		$data['TITLE'] = "Услови регистрације";

		echo view('template/header', $data);
		echo view('user/terms');
		echo view('template/footer'); 
	}

}
