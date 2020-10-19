<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {
	protected $table = 'users';
    protected $allowedFields = ['name', 'email', 'hash', 'status', 'permission'];
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
}


