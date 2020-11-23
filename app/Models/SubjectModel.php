<?php namespace App\Models;

use CodeIgniter\Model;

class SubjectModel extends Model
{
	protected $table = 'subjects';
	protected $allowedFields = ['name', 'code'];
	protected $returnType = 'object';

	public function getUsedSubjectsOptionList($subject_id = 1)
	{
		$subjects = $this->db->query('SELECT * FROM subjects WHERE id IN (SELECT subject FROM exams) ORDER BY name')->getResult();
		$str = '';

		foreach ($subjects as $subject)
		{
			if ($subject_id == $subject->id)
				$select = 'selected="selected"';
			else
				$select = '';

			$str = $str . ("<option $select value=\"$subject->id\">$subject->name ($subject->code)</option>");
		}

		return $str;
	}

	public function getAllSubjectsOptionList($subject_id = 1)
	{
		$subjects = $this->findAll();
		$str = '';

		foreach ($subjects as $subject)
		{
			if ($subject_id == $subject->id)
				$select = 'selected="selected"';
			else
				$select = '';

			$str = $str . ("<option $select value=\"$subject->id\">$subject->name ($subject->code)</option>");
		}

		return $str;
	}
}