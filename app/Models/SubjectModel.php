<?php namespace App\Models;

use CodeIgniter\Model;

class SubjectModel extends Model{
	protected $table = 'subjects';
	protected $allowedFields = ['name', 'code'];
	protected $returnType = 'object';


	public function getUsedSubjectsOptionList() {
		$subjects = $this->db->query('SELECT * FROM subjects WHERE id IN (SELECT subject FROM exams) ORDER BY name')->getResult();
		$str = '';

		foreach ($subjects as $subject) {
			$str = $str . ("<option value=\"$subject->id\">$subject->name ($subject->code)</option>");
		}

		return $str;
	}


	public function getAllSubjectsOptionList($ID = 1) {
		$subjects = $this->findAll();
		$str = '';

		foreach ($subjects as $subject) {
			if ($ID == $subject->id)
				$select = 'selected="selected"';
			else
				$select = '';
			$str = $str . ("<option $select value=\"$subject->id\">$subject->name ($subject->code)</option>");
		}

		return $str;
	}


}