<?php namespace App\Controllers;

use App\Models\ExamModel;
use App\Models\SubjectModel;
use App\Models\ProblemModel;
use App\Models\UserModel;

class Home extends BaseController
{
	public function index()
	{
		$data['TITLE'] = "Почетна";

		$examModel = new ExamModel();
		$data['examsTable'] = $examModel->generateTable($examModel->orderBy('created_at', 'DESC')->limit(10)->find());
		$data['numberOfExams'] = $examModel->countAll();

		$problemModel = new ProblemModel();
		$data['numberOfProblems'] = $problemModel->countAll();

		$userModel = new UserModel();
		$data['numberOfUsers'] = $userModel->countAll();
		
		echo view('pages/home', $data);
	}

	public function sitemap()
	{
		$examModel = new ExamModel();
		$data['exams'] = $examModel->findAll();

		$subjectModel = new SubjectModel();
		$data['subjects'] = $subjectModel->findAll();

		$this->response->setHeader('Content-Type', 'text/xml;charset=iso-8859-1');
        echo view("sitemap", $data);
	}

	public function tools()
	{
		$data['TITLE'] = "Алати";

		echo view('pages/tools', $data);
	}

	public function about()
	{
		$data['TITLE'] = "О пројекту";
		echo view('pages/about', $data);
	}

	public function manual()
	{
		$data['TITLE'] = "Упутство";
		echo view('pages/manual', $data);
	}
}
