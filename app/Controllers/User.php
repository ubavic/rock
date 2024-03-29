<?php namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ExamModel;
use App\Models\LogModel;

class User extends BaseController
{
	private $errors = [
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

	public function index($user_id = NULL)
	{
		if (is_null($user_id)) {
			session()->setFlashdata('error', 'Дошло је до грешке.');
			return redirect()->to('/');
		}

		$userModel = new UserModel();
		$user = $userModel->find($user_id);

		if (is_null($user)) {
			session()->setFlashdata('error', 'Дошло је до грешке. Корисник није пронађен');
			return redirect()->to('/');
		}

		$data['TITLE'] = 'Кориснички профил';
		$data['user'] = $user;

		$examModel = new ExamModel();
		$data['count'] = $examModel->where('created_by', $user_id)->countAllResults();

		echo view('user/profile', $data);
	}

	public function changePermissions($id = null)
	{
		if ($id === null) {
			session()->setFlashdata('error', 'Дошло је до грешке.');
			return redirect()->to('/');
		}

		$userModel = new UserModel();
		$user = $userModel->find($id);

		if ($user === null){
			session()->setFlashdata('error', 'Дошло је до грешке. Корисник није пронађен');
			return redirect()->to('/user/controlpanel');
		}

		$userModel->update($id, [
			'can_add' => $this->request->getVar('can_add'),
			'can_edit' => $this->request->getVar('can_edit'),
			'can_delete' => $this->request->getVar('can_delete'),
			'can_manage_users' => $this->request->getVar('can_manage_users'),
			'can_manage_subjects' => $this->request->getVar('can_manage_subjects'),
		]);

		session()->setFlashdata('success', 'Дозволе корисника су успешно промењене.');

		return $this->index($id);
	}

	public function userExams($user_id = NULL)
	{
		if (is_null($user_id))
		{
			session()->setFlashdata('error', 'Дошло је до грешке.');
			return redirect()->to('/');
		}

		$userModel = new UserModel();
		$user = $userModel->find($user_id);
		
		if (is_null($user))
		{
			session()->setFlashdata('error', 'Дошло је до грешке.');
			return redirect()->to('/');
		}

		$data['TITLE'] = 'Рокови корисника ' . $user->name;
		$data['user'] = $user;

		$examModel = new ExamModel();
		$data['createdExams'] = $examModel->generateTable($examModel->where('created_by', $user_id)->findAll());

		echo view('user/exams', $data);
	}

	
	public function login()
	{
		$data['TITLE'] = 'Пријавите се';
		helper(['form']);

		if (strcmp(previous_url(), base_url() . "/user/login"))
			session()->setFlashdata('back_to', str_replace(base_url(), "", previous_url()));

		echo view('user/login', $data);
	}

	public function loginPost()
	{
		helper(['form']);
		$logModel = new LogModel();
		$rules = [
			'email'        => 'required|valid_email',
			'password'     => 'required|validateUser[email,password]|validatedMail[email]'
		];

		if ($this->validate($rules, $this->errors))
		{
			$userModel = new UserModel();
			$user = $userModel->where('email', $this->request->getVar('email'))->first();
			$this->setUser($user);

			$logModel->insert([
				'user' => $user->id,
				'ip' => $this->request->getIPAddress(),
			]);

			session()->setFlashdata('success', 'Успешно сте се пријавили.');

			if (!is_null(session()->getFlashdata('back_to')))
				return redirect()->to(session()->getFlashdata('back_to'));
			else
				return redirect()->to('/');
		}
		else
		{
			$logModel->insert([
				'user' => NULL,
				'ip' => $this->request->getIPAddress(),
			]);

			session()->setFlashdata('error', $this->validator->listErrors());
			return redirect()->to('/user/login');
		}
	}

	public function register()
	{
		$data['TITLE'] = 'Региструјте се';
		echo view('user/register', $data);
	}

	public function registerPost()
	{
		$data['TITLE'] = 'Региструјте се';
		helper(['form']);
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
			];
			$userModel = new UserModel();
			$userModel->insert($regData);
			$userModel->sendVerificationMail($userModel->getInsertID());

			session()->setFlashdata('success', 'Да би сте завршили регистрацију потврдите Вашу адресу кликом на линк који Вам је послат.');
			return redirect()->to('/user/login');
		}
		else
		{
			session()->setFlashdata('error', $this->validator->listErrors());
			return redirect()->to('/user/register');
		}
	}

	private function setUser($user)
	{
		$data = [
			'id' => $user->id,
			'name' => $user->name,
			'logged' => true,
			'can_add' => $user->can_add,
			'can_edit' => $user->can_edit,
			'can_delete' => $user->can_delete,
			'can_manage_users' => $user->can_manage_users,
			'can_manage_subjects' => $user->can_manage_subjects
		];

		session()->set($data);
		
		return true;
	}

	public function logout()
	{
		session()->destroy();

		return redirect()->to('/');
	}

	public function terms()
	{
		$data['TITLE'] = 'Услови регистрације';

		echo view('user/terms', $data);
	}

	public function verify($user_id = NULL, $code = NULL)
	{
		if (is_null($user_id) || is_null($code))
		{
			session()->setFlashdata('error', 'Дошло је до грешке приликом потврђивања адресе.');
			return redirect()->to('/');
		}

		$userModel = new UserModel();
		$user = $userModel->find($user_id);

		if (is_null($user))
		{
			session()->setFlashdata('error', 'Дошло је до грешке приликом потврђивања адресе.');
			return redirect()->to('/');
		}

		if ($user->ver_code == NULL)
			session()->setFlashdata('success', 'Већ сте успешно потврдили адресу. Можете се пријавити.');
		else if ($user->ver_code == $code)
		{
			session()->setFlashdata('success', 'Адреса је успешно потврђена. Можете се пријавити.');
			$userModel->update($user_id, [
				'status' => 1,
				'ver_code' => NULL
			]);
		}
		else
		{
			$userModel->sendVerificationMail($user_id);
			session()->setFlashdata('error', 'Дошло је до грешке приликом потврђивања адресе. Послат Вам је нови линк.');
		}

		return redirect()->to('/user/login');
	}

	public function resetPassword()
	{
		$data['TITLE'] = 'Повратак шифре';
		echo view('user/passwordReset', $data);
	}

	public function resetPasswordPost()
	{
		helper(['form']);
		$userModel = new UserModel();
		$rules = ['email' => 'required|valid_email'];

		if ($this->validate($rules, $this->errors))
		{
			$user = $userModel->where('email', $this->request->getVar('email'))->first();

			if (!is_null($user))
				$userModel->sendNewPassword($user->id);

			session()->setFlashdata('success', 'Захтев за промену шифре је прихваћен. Даље инструкције о промени шифре ће бити послате на унету мејл адресу (ако је то адреса неког од корисника).');
			return redirect()->to('/user/login');
		}
		else
		{
			session()->setFlashdata('error', $this->validator->listErrors());
			return redirect()->to('/user/resetPassword');
		}
	}
}
