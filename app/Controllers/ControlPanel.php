<?php namespace App\Controllers;

use App\Models\ExamModel;
use App\Models\ExamLogModel;
use App\Models\LogModel;
use App\Models\UserModel;
use App\Models\SavedExamModel;

class ControlPanel extends BaseController
{
	private $errors = [
		'name' => [
			'required' => 'Име је обавезно',
			'min_length' => 'Име мора да садржи барем 3 карактера.',
			'max_length' => 'Име може да садржи највише 255 карактера.'
		],
		'password' => [
			'required' => 'Шифра је обавезна.',
			'min_length' => 'Шифра мора имати најмање осам карактера.',
			'max_length' => 'Шифра може имати највише 255 карактера.'
		],
		'pass_confirm' => [
			'required_with' => 'Морате поновити шифру.',
			'matches' => 'Шифре морају бити исте.'
		],
	];

	public function settings()
	{
		$data['TITLE'] = 'Подешавања';

		$userModel = new UserModel();
		$data['user'] = $userModel->find(session()->get('id'));

		echo view('controlPanel/settings', $data);
	}

	public function settingsPost()
	{
		helper(['form']);
		$userModel = new UserModel();

		if ($this->request->getPost('name'))
		{
			$rules = [
				'name' => 'required|min_length[3]|max_length[255]',
			];

			if ($this->validate($rules, $this->errors))
			{
				$userModel->save([
					'id' => session()->get('id'),
					'name' => $this->request->getVar('name'),
				]);
				session()->set('name', $this->request->getVar('name'));
				session()->setFlashdata('success', 'Име је успешно промењено.');
			} else
			{
				$data['validation'] = $this->validator;
			}
		}
		else if ($this->request->getPost('password'))
		{
			$rules = [
				'password'     => 'required|min_length[8]|max_length[255]',
				'pass_confirm' => 'required_with[password]|matches[password]',
			];
	
			if ($this->validate($rules, $this->errors))
			{
				$userModel->save([
					'id' => session()->get('id'),
					'hash' => $this->request->getVar('password'),
				]);
				session()->setFlashdata('success', 'Шифра је успешно промењена.');
			} else {
				$data['validation'] = $this->validator;
			}
		}

		return redirect()->to('/cp/settings');
	}


	public function savedExams()
	{
		$data['TITLE'] = 'Сачувани рокови';

		$saved_exam_model = new SavedExamModel();
		$exam_model = new ExamModel();
		
		$saved_exams = $saved_exam_model->userSavedExams(session()->get('id'));
		$data['exam_table'] = $exam_model->generateTable($exam_model->getMetadata(['data' => $saved_exams])['data']);

		echo view('controlPanel/savedExams', $data);
	}


	public function all()
	{
		$data['TITLE'] = 'Сви корисници';

		$user_model = new UserModel();
		$users = $user_model->findAll();

		foreach ($users as $user){
				$user->user_link = $user_model->getAbbr($user->id);
		}

		$data['users'] = $users;

		echo view('controlPanel/all', $data);
	}

	public function loginLog()
	{
		$data['TITLE'] = 'Списак пријављивања';

		$user_model = new UserModel();
		$log_model = new LogModel();
		$logs = $log_model->orderBy('time', 'DESC')->limit(20)->find();

		foreach ($logs as $entry)
		{
			if ($entry->user != 0)
				$entry->user_link = $user_model->getAbbr($entry->user);
			else
				$entry->user_link = 'Нерегистрован корисник';
		}

		$data['logs'] = $logs;

		echo view('controlPanel/loginLog', $data);
	}


	public function statistics()
	{
		$data['TITLE'] = 'Статистика';
		echo view('controlPanel/statistics', $data);
	}

	public function getStatistics()
	{
		$examLog = new ExamLogModel();
		$query = $examLog->db->query('
			SELECT COUNT(*) AS "hits", DATE(time) AS "date" FROM exam_log
			WHERE time >= (CURRENT_TIMESTAMP - interval \'60\' day)
			GROUP BY DATE(time)');

		return $this->response->setJSON($query->getResult());	
	}

	public function getStatisticsForDay($day, $month, $year)
	{
		if ($day > 31)
			return $this->response->setJSON(['error' => 'day']);
		if ($month > 12)
			return $this->response->setJSON(['error' => 'month']);
		if ($year < 20)
			return $this->response->setJSON(['error' => 'year']);

		$year = 2000 + $year;

		$examLog = new ExamLogModel();
		$query = $examLog->db->query("
		SELECT hits, exam, name FROM (
			SELECT hits, exam, subject FROM (
				SELECT COUNT(*) AS \"hits\", exam FROM exam_log
				WHERE DAY(time) = {$day} AND MONTH(time) = {$month} AND YEAR(time) = {$year}  
				GROUP BY exam) AS t
			LEFT JOIN exams
			ON t.exam = exams.id) AS t
		LEFT JOIN subjects
		ON t.subject = subjects.id
		ORDER BY hits DESC
		LIMIT 10");

		return $this->response->setJSON($query->getResult());
	}
}