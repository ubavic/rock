<?php
namespace App\Validation;
use App\Models\UserModel;

class UserRules
{
	public function validateUser(string $str, string $fields, array $data)
	{
		$model = new UserModel();
		$user = $model->where('email', $data['email'])->first();

		if(!$user)
			return false;

		return password_verify($data['password'], $user->hash);
	}

	public function validatedMail(string $str, string $fields, array $data)
	{
		$model = new UserModel();
		$user = $model->where('email', $data['email'])->first();

		if(!$user)
			return false;

		if ($user->ver_code == NULL)
			return True;
		else
			return False;
	}

	public function validateFacultyMail(string $str, string $fields, array $data)
	{
		$mail = $data['email'];
		$domain = substr($mail, strpos($mail, "@") + 1);
		$whitelist = [
			'matf.bg.ac.rs',
			'alas.matf.bg.ac.rs',
			'math.rs',
		];

		if(in_array($domain, $whitelist))
			return True;
		else
			return False;
	}
}