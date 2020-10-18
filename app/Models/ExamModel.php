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
								'updated_by'
							];
	protected $useTimestamps = true;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $useSoftDeletes = true;
	protected $afterFind = ['getMetadata'];

	public function getModulesArray (int $a) {
		$array = [];

		for ($i = 0; $i < 7; $i++) {
			if (fmod ($a, 2) == 1) {
				$array[$i] = True;
			} else {
				$array[$i] = False;
			}

			$a = intdiv($a, 2);
		}

		return $array;
	}

	public function getModulesString (array $a) {
		$modules = ['АА', 'И', 'МЛ', 'ММ', 'МП', 'МР', 'МС'];
		$true_modules = [];

		$j = 0;
		for ($i = 0; $i < 7; $i++) {
			if ($a[$i] == True) {
				$true_modules[$j] = $modules[$i];
				$j++;
			}
		}

		return implode(", ", $true_modules);
	}

	public function getModulesInt (array $a) {
		$s = 0;
	
		for ($i = 0; $i < 7; $i++) {
			if (in_array($i, $a)) {
				$s = $s + (2 ** $i);
			}
		}

		return $s;
	}

	private function getClassName (int $ID) {
		return (($this->db->table('subjects')->where('id', $ID)->get()->getResult())[0])->name;
	}

	public function getExams() {
		return $this->findAll();
	}
	
	public function getExam($ID){
		return $this->find($ID);
	}

	public function getLastTenExams () {
		return $this->orderBy('created_at', 'DESC')->limit(5)->findAll();
	}

	public function getMetadata (array $data) {

		if(is_array($data['data'])){
			foreach ($data['data'] as &$exam) {
				$exam->subject_name = $this->getClassName(intval($exam->subject));
				$exam->modules_string = $this->getModulesString($this->getModulesArray($exam->modules));
			}
		} else {
			$data['data']->subject_name = $this->getClassName(intval($data['data']->subject));
			$data['data']->modules_string = $this->getModulesString($this->getModulesArray($data['data']->modules));
		}

		return $data;
	}
}