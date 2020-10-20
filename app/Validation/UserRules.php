<?php
namespace App\Validation;
use App\Models\UserModel;

class UserRules
{
	public function validateUser(string $str, string $fields, array $data){
		$model = new UserModel();
		$user = $model->where('email', $data['email'])->first();

		if(!$user)
			return false;

		return password_verify($data['password'], $user->hash);
	}

	public function validatedMail(string $str, string $fields, array $data){
		$model = new UserModel();
		$user = $model->where('email', $data['email'])->first();

		if(!$user)
			return false;

		if ($user->ver_code == NULL)
			return True;
		else
			return False;

	}
	
}