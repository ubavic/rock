<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {
	protected $table = 'users';
	protected $allowedFields = ['name',
								'email',
								'hash',
								'status',
								'can_add',
								'can_delete',
								'can_edit',
								'ver_code'];
	protected $useTimestamps = true;
	protected $returnType = 'object';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $useSoftDeletes = true;
	protected $beforeInsert = ['beforeInsert'];
	protected $beforeUpdate = ['beforeUpdate'];

	protected function beforeInsert (array $data) {
		$data = $this->passwordHash($data);
		return $data;
	}

	protected function beforeUpdate (array $data) {
		$data = $this->passwordHash($data);
		return $data;
	}

	protected function passwordHash (array $data) {
		if(isset($data['data']['hash']))
			$data['data']['hash'] = password_hash($data['data']['hash'], PASSWORD_DEFAULT);
		
		return $data;
	}

	public function getAbbr($ID) {
		$user = $this->find($ID);
		return "<abbr title=\"$user->email\">" . $user->name . '</abbr>';
	}

	public function sendVerificationMail($ID){
		$code = random_int (100000, 999999);
		$this->save(['id' => $ID, 'ver_code' => $code]);

		$message = 'Хвала Вам што сте се регистровали на сајт МАТФ Рокови.\n';
		$message .= 'Кликом на следећи линк верификоваћетзе вашу адресу:\n';
		$message .= (base_url() . "/user/$ID/$code\n\n" );
		
		$email = \Config\Services::email();

		$user = $this->find($ID);
		$email->setFrom('rokovi@ubavic.rs', 'MATF Rokovi');
		$email->setTo($user->email);

		$email->setSubject('Verifikacija email adrese');
		$email->setMessage($message);

		$email->send();
	}

}


