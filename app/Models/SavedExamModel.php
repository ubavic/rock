<?php namespace App\Models;

use CodeIgniter\Model;

class SavedExamModel extends Model
{
	protected $table = 'saved_exams';
	protected $returnType = 'object';
	protected $primaryKey = 'id';
	protected $allowedFields = ['user', 'exam'];
	protected $useTimestamps = false;
	protected $useSoftDeletes = false;

	public function userSavedExams ($id) {
		return $this->db->query('SELECT exams.*, saved_exams.save_time 
			FROM saved_exams 
			LEFT JOIN exams ON saved_exams.exam = exams.id 
			WHERE saved_exams.user = ' . $id . ' ORDER BY saved_exams.save_time DESC')->getResult();
	}
}
