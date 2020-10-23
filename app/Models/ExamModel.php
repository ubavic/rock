<?php namespace App\Models;

use CodeIgniter\Model;

class ExamModel extends Model{
	protected $table = 'exams';
	protected $returnType = 'object';
	protected $primaryKey = 'id';
	protected $allowedFields = ['subject',
								'type',
								'date',
								'modules',
								'duration',
								'note',
								'additional_note',
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

	public function getModulesString ($exam) {
		$true_modules = [];

		if($exam->ma)
			$true_modules = array_merge($true_modules, ['АА']);

		if($exam->mi)
			$true_modules = array_merge($true_modules, ['И']);

		if($exam->ml)
			$true_modules = array_merge($true_modules, ['МЛ']);

		if($exam->mm)
			$true_modules = array_merge($true_modules, ['ММ']);

		if($exam->mp)
			$true_modules = array_merge($true_modules, ['МП']);

		if($exam->mr)
			$true_modules = array_merge($true_modules, ['МР']);

		if($exam->ms)
			$true_modules = array_merge($true_modules, ['МС']);

		return implode(", ", $true_modules);
	}

	private function getClassName (int $ID) {
		return (($this->db->table('subjects')->where('id', $ID)->get()->getResult())[0])->name;
	}

	public function getLastTenExams () {
		return $this->orderBy('created_at', 'DESC')->limit(5)->findAll();
	}

	public function getMetadata (array $data) {

		if(is_array($data['data'])){
			foreach ($data['data'] as &$exam) {
				$exam->subject_name = $this->getClassName(intval($exam->subject));
				$exam->modules_string = $this->getModulesString($exam);
				$exam->date = date_format(date_create($exam->date), 'd.m.Y.');
			}
		} else {
			$data['data']->subject_name = $this->getClassName(intval($data['data']->subject));
			$data['data']->modules_string = $this->getModulesString($data['data']);
			$data['data']->date = date_format(date_create($data['data']->date), 'd.m.Y.');
			$data['data']->created_at = date_format(date_create($data['data']->created_at), 'd.m.Y. у H.i');
			$data['data']->updated_at = date_format(date_create($data['data']->updated_at), 'd.m.Y. у H.i');
		}

		return $data;
	}
}