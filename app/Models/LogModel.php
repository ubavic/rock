<?php namespace App\Models;

use CodeIgniter\Model;

class LogModel extends Model
{
	protected $table = 'login_log';
	protected $returnType = 'object';
	protected $allowedFields = ['user', 'time', 'ip'];
	protected $useTimestamps = false;
	protected $useSoftDeletes = false;
}
