<?php namespace App\Models;

use CodeIgniter\Model;

class SubjectModel extends Model{
	protected $table = 'subjects';
	protected $allowedFields = ['name', 'code'];
	
	public function getAllSubjectsOptionList () {
		$subjects = $this->findAll();

		$str = '';

		foreach ($subjects as $subject) {
			$str = $str . ('<option value="' . $subject['id'] . '">' . $subject['code'] . '  ' . $subject['name'] . '</option>');
		}

		return $str;
	}

	public function getSubject ($ID) {
		$row = $this->find($ID);
		$subject = (object) [
			'name' => $row['class'],
			'code' => $row['code']
		];

		return $subject;
	}

}