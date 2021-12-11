<?php namespace App\Models;

use CodeIgniter\Model;

class ExamLogModel extends Model
{
	protected $table = 'exam_log';
	protected $returnType = 'object';
	protected $allowedFields = ['exam'];
	protected $useTimestamps = false;
	protected $useSoftDeletes = false;
}
