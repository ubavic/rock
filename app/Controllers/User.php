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
			'validateFacultyMail' => 'Регистрација се мора обавити са факултетским мејл налогом.'
		],
		'password' => [
			'required' => 'Шифра је обавезна.',
			'min_length' => 'Шифра мора имати најмање осам карактера.',
			'max_length' => 'Шифра може имати највише 255 карактера.',
			'validateUser' => 'Email и/или шифра нису тачни.',
			'validatedMail' => 'Морате верификовати мејл адресу кликом на линк који вам је послат.'
		],
		'pass_confirm' => [
			'required_with' => 'Морате поновити шифру.',
			'matches' => 'Шифре морају бити исте.'
		],
	];

	public function index($user_id)
	{
		$userModel = new UserModel();
		$user = $userModel->find($user_id);

		if (is_null($user))
			return redirect()->to('/user/controlpanel');

		$data['TITLE'] = 'Кориснички профил';
		$data['user'] = $user;

		echo view('user/profile', $data);
	}
	
	public function login()
	{
		$data['TITLE'] = 'Пријавите се';
		helper(['form']);

		if ($this->request->getMethod() == 'post')
		{
			$logModel = new LogModel();
			$rules = [
				'email'        => 'required|valid_email',
				'password'     => 'required|validateUser[email,password]|validatedMail[email]'
			];

			if ($this->validate($rules, $this->errors))
			{
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
			} else
			{
				$logModel->save([
					'user' => NULL,
					'ip' => $this->request->getIPAddress(),
				]);

				$data['validation'] = $this->validator;

				echo view('user/login', $data);
			}
		} else
		{
			echo view('user/login', $data);
		}
	}

	public function register()
	{
		$data['TITLE'] = 'Региструјте се';
		helper(['form']);

		if ($this->request->getMethod() == 'post')
		{
			$rules = [
				'email'        => 'required|valid_email|is_unique[users.email]|validateFacultyMail[email]',
				'password'     => 'required|min_length[8]|max_length[255]',
				'pass_confirm' => 'required_with[password]|matches[password]',
			];

			if ($this->validate($rules, $this->errors))
			{
				$regData = [
					'name' => $this->request->getVar('email'),
					'email' => $this->request->getVar('email'),
					'hash' => $this->request->getVar('password'),
					'status' => 0,
					'permission' => 0
				];

				$userModel = new UserModel();
				$userModel->save($regData);
				$user = $userModel->where('email', $this->request->getVar('email'))->first();
				$userModel->sendVerificationMail($user->id);
				session()->setFlashdata('success', 'Да би сте завршили регистрацију потврдите Вашу адресу кликом на линк који Вам је послат.');

				return redirect()->to('/user/login');
			} else
			{
				$data['validation'] = $this->validator;

				echo view('user/register', $data);
			}
		} else
		{
			echo view('user/register', $data);
		}
	}

	public function settings()
	{
		$data['TITLE'] = 'Подешавања';
		helper(['form']);

		$userModel = new UserModel();

		if ($this->request->getMethod() == 'post')
		{
			if ($this->request->getPost('name'))
			{
				$rules = [
					'name' => 'required|min_length[3]|max_length[255]',
				];

				if ($this->validate($rules, $this->errors))
				{
					$userModel->save([
						'id' => session()->get('id'),
						'name' => $this->request->getVar('name'),
					]);
					session()->set('name', $this->request->getVar('name'));
					session()->setFlashdata('success', 'Име је успешно промењено.');
				} else
				{
					$data['validation'] = $this->validator;
				}
			} else if ($this->request->getPost('password'))
			{
				$rules = [
					'password'     => 'required|min_length[8]|max_length[255]',
					'pass_confirm' => 'required_with[password]|matches[password]',
				];
		
				if ($this->validate($rules, $this->errors))
				{
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
		$data['name'] = $user->name;
		$data['email'] = $user->email;

		echo view('user/controlPanel/settings', $data);
	}

	public function exams()
	{
		$data['TITLE'] = 'Додати рокови';

		$examModel = new ExamModel();
		$data['createdExams'] = $examModel->generateTable($examModel->where('created_by', session()->get('id'))->findAll());

		echo view('user/controlPanel/exams', $data);
	}

	public function saved()
	{
		$data['TITLE'] = 'Сачувани рокови';

		echo view('user/controlPanel/saved', $data);
	}

	public function all()
	{
		$data['TITLE'] = 'Сви корисници';

		$user_model = new UserModel();
		$users = $user_model->findAll();

		foreach ($users as $user){
				$user->user_link = $user_model->getAbbr($user->id);
		}

		$data['users'] = $users;

		echo view('user/controlPanel/all', $data);
	}

	public function log()
	{
		$data['TITLE'] = 'Списак пријављивања';

		$user_model = new UserModel();
		$log_model = new LogModel();
		$logs = $log_model->orderBy('time', 'DESC')->limit(20)->find();

		foreach ($logs as $entry){
			if ($entry->user != 0)
				$entry->user_link = $user_model->getAbbr($entry->user);
			else
				$entry->user_link = 'Нерегистрован корисник';
		}

		$data['logs'] = $logs;

		echo view('user/controlPanel/log', $data);
	}

	private function setUser($user)
	{
		$data = [
			'id' => $user->id,
			'name' => $user->name,
			'logged' => true,
			'can_manage_users' => $user->can_manage_users
		];

		session()->set($data);
		session()->setFlashdata('success', 'Успешно сте се пријавили.');
		
		return true;
	}

	public function logout()
	{
		session()->destroy();
		
		$session = session();
		session()->setFlashdata('success', 'Успешно сте се одјавили.');

		return redirect()->to('/');
	}

	public function terms()
	{
		$data['TITLE'] = 'Услови регистрације';

		echo view('user/terms', $data);
	}

	public function verify($ID, $code)
	{
		$userModel = new UserModel();
		$user = $userModel->find($ID);

		if ($user->ver_code == NULL)
		{
			session()->setFlashdata('success', 'Већ сте успешно потврдили адресу. Можете се пријавити.');
		} else if ($user->ver_code == $code)
		{
			session()->setFlashdata('success', 'Адреса је успешно потврђена. Можете се пријавити.');
			$userModel->save(['id' => $ID, 'ver_code' => NULL]);
		} else
		{
			$userModel->sendVerificationMail($ID);
			session()->setFlashdata('success', 'Дошло је до грешке приликом потврђивања адресе. Послат Вам је нови линк.');
		}

		return redirect()->to('/user/login');
	}


	public function resetPassword()
	{
		$data['TITLE'] = 'Повратак шифре';
		helper(['form']);

		$userModel = new UserModel();

		if ($this->request->getMethod() == 'post')
		{
			$rules = ['email' => 'required|valid_email'];
		
			if ($this->validate($rules, $this->errors))
			{
				$user = $userModel->where('email', $this->request->getVar('email'))->first();
				if ($user != NULL){
					$userModel->sendNewPassword($user->id);
					session()->setFlashdata('success', 'Ваша нова шифра Вам је послата на мејл.');
				}

				return redirect()->to('/user/login');

			} else {
				$data['validation'] = $this->validator;
			}
		}

		echo view('user/passwordReset', $data);
	}
}