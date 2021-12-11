<?php namespace App\Models;

use CodeIgniter\Model;

class SubjectModel extends Model
{
	protected $table = 'subjects';
	protected $allowedFields = ['name', 'code'];
	protected $returnType = 'object';
	protected $useSoftDeletes = false;

	public function getUsedSubjectsOptionList($id = 1)
	{
		$subjects = $this->db->query('SELECT * FROM subjects WHERE id IN (SELECT subject FROM exams) ORDER BY name')->getResult();
		$str = '';

		foreach ($subjects as $subject) {
			if ($id == $subject->id)
				$select = 'selected="selected"';
			else
				$select = '';

			$str = $str . ("<option $select value=\"$subject->id\">$subject->name ($subject->code)</option>");
		}

		return $str;
	}

	public function getAllSubjectsOptionList($id = 1)
	{
		$subjects = $this->findAll();
		$str = '';

		foreach ($subjects as $subject) {
			if ($id == $subject->id)
				$select = 'selected="selected"';
			else
				$select = '';

			$str = $str . ("<option $select value=\"$subject->id\">$subject->name ($subject->code)</option>");
		}

		return $str;
	}

	public function getUsedSubjectCount()
	{
		return $this->db->
			query('SELECT * FROM (SELECT COUNT(id) AS count, subject FROM exams GROUP BY subject) AS exam LEFT JOIN subjects ON exam.subject = subjects.id')
			->getResult();
	}
}
