<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
	protected $table = 'users';
	protected $allowedFields = ['name',
								'email',
								'hash',
								'status',
								'can_add',
								'can_delete',
								'can_edit',
								'can_manage_users',
								'ver_code'];
	protected $useTimestamps = true;
	protected $returnType = 'object';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $useSoftDeletes = true;
	protected $beforeInsert = ['beforeInsert'];
	protected $beforeUpdate = ['beforeUpdate'];

	protected function beforeInsert(array $data)
	{
		$data = $this->passwordHash($data);
		return $data;
	}

	protected function beforeUpdate(array $data)
	{
		$data = $this->passwordHash($data);
		return $data;
	}

	protected function passwordHash(array $data)
	{
		if (isset($data['data']['hash']))
			$data['data']['hash'] = password_hash($data['data']['hash'], PASSWORD_DEFAULT);
		
		return $data;
	}

	public function getAbbr($user_id)
	{
		$user = $this->find($user_id);

		if (is_null($user))
			return "<i>Непознат корисник</i>";

		return "<a href=\"/user/$user_id\">$user->name</a>";
	}

	public function sendVerificationMail($ID)
	{
		$code = random_int(100000, 999999);
		$this->save(['id' => $ID, 'ver_code' => $code]);

		$message = "Хвала Вам што сте се регистровали на сајт МАТФ Рокови.\n";
		$message .= "Кликом на следећи линк потврдићете Вашу адресу:\n";
		$message .= (base_url() . "/user/verify/$ID/$code\n\n" );
		
		$email = \Config\Services::email();

		$user = $this->find($ID);
		$email->setFrom('rokovi@ubavic.rs', 'MATF Rokovi');
		$email->setTo($user->email);

		$email->setSubject('Verifikacija email adrese');
		$email->setMessage($message);

		$email->send();
	}

	public function sendNewPassword($ID)
	{
		$pass = "MATF" . random_int(10000000, 99999999) . "ROKOVI";
		$this->save(['id' => $ID, 'hash' => $pass]);

		$message = "Ваша нова шифра је\n";
		$message .= $pass;
		$message .= "\nАко ви нисте затражили промену шифре, обратите се администратору!\n";
		
		$email = \Config\Services::email();

		$user = $this->find($ID);
		$email->setFrom('rokovi@ubavic.rs', 'MATF Rokovi');
		$email->setTo($user->email);

		$email->setSubject('Nova lozinka');
		$email->setMessage($message);

		$email->send();
	}

	public function canEditExam($user_id, $exam_id)
	{
		$user = $this->find($user_id);

		if ($user->can_edit == 0)
			return 0;

		if ($user->can_edit == 2)
			return 1;

		$examModel = new ExamModel();
		if ($examModel->find($exam_id)->created_by == $user_id)
			return 1;

		return 0;
	}
}