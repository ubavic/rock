<?php namespace App\Models;

use CodeIgniter\Model;

class ExamModel extends Model
{
	protected $table = 'exams';
	protected $returnType = 'object';
	protected $primaryKey = 'id';
	protected $allowedFields = ['subject',
								'type',
								'date',
								'modules',
								'duration',
								'note',
								'created_by',
								'updated_by',
								'ma',
								'mi',
								'ml',
								'mm',
								'mp',
								'mr',
								'ms',
							];
	protected $useTimestamps = true;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $useSoftDeletes = true;
	protected $afterFind = ['getMetadata'];

	public function getModulesString($exam)
	{
		$true_modules = [];

		if ($exam->ma)
			$true_modules = array_merge($true_modules, ['А']);

		if ($exam->mi)
			$true_modules = array_merge($true_modules, ['И']);

		if ($exam->ml)
			$true_modules = array_merge($true_modules, ['Л']);

		if ($exam->mm)
			$true_modules = array_merge($true_modules, ['М']);

		if ($exam->mp)
			$true_modules = array_merge($true_modules, ['Н']);

		if ($exam->mr)
			$true_modules = array_merge($true_modules, ['Р']);

		if ($exam->ms)
			$true_modules = array_merge($true_modules, ['В']);

		return implode(", ", $true_modules);
	}

	private function getClassName(int $ID)
	{
		return (($this->db->table('subjects')->where('id', $ID)->get()->getResult())[0])->name;
	}

	public function getMetadata($data)
	{
		if (is_array($data['data']))
		{
			foreach ($data['data'] as &$exam)
			{
				$exam->subject_name = $this->getClassName(intval($exam->subject));
				$exam->modules_string = $this->getModulesString($exam);
				$exam->date_string = date_format(date_create($exam->date), 'd.m.Y.');
			}
		} else
		{
			$data['data']->subject_name = $this->getClassName(intval($data['data']->subject));
			$data['data']->modules_string = $this->getModulesString($data['data']);
			$data['data']->date_string = date_format(date_create($data['data']->date), 'd.m.Y.');
			$data['data']->created_at = date_format(date_create($data['data']->created_at), 'd.m.Y. у H.i');
			$data['data']->updated_at = date_format(date_create($data['data']->updated_at), 'd.m.Y. у H.i');
		}

		return $data;
	}

	public function generateTable($exams)
	{
		$head ='<div class="tableList">
					<div class="tableListHeader">
						<div class="examListType"><abbr title="Колоквијум">Клк</abbr></div>
						<div class="examListSubject">Предмет</div>
						<div class="examListDate">Датум</div>
						<div class="examListModules">Смер</div>
					</div>';
		$results = '';

		if (empty($exams))
		{
			$results = '<div style="text-align: center; padding: 1em; max-width: 600px; margin: 0 auto;">
			Нема рокова који задовољавају критеријум.</div>';
		} else
		{
			foreach ($exams as $exam)
			{
				$type = ($exam->type == 0) ? ' ' : 'К';
				$results .= "<a href=\"/exam/view/$exam->id\" class=\"tableListRow\">
						<div class=\"examListType\">$type</div>
						<div class=\"examListSubject\">$exam->subject_name</div>
						<div class=\"examListDate\">$exam->date_string</div>
						<div class=\"examListModules\">$exam->modules_string</div>
					</a>";
			}
		}

		return $head . $results . '</div>';
	}
}