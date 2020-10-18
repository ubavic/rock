<?php namespace App\Models;

use CodeIgniter\Model;

class ProblemModel extends Model{
	protected $table = 'problems';
	protected $allowedFields = ['exam', 'text'];
	protected $useTimestamps = false;
	protected $useSoftDeletes = false;

	public function getProblems($ID){
		return $this->where('exam', $ID)->get()->getResult();
	}

}