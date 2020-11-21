<?php namespace App\Controllers;

use App\Models\ExamModel;
use App\Models\SubjectModel;
use App\Models\ProblemModel;
use App\Models\UserModel;

class Home extends BaseController
{
	public function index(){
		$data['TITLE'] = "Почетна";

		$examModel = new ExamModel();
		$data['exams'] = $examModel->orderBy('created_at', 'DESC')->limit(5)->find();
		$data['numberOfExams'] = $examModel->countAll();

		$problemModel = new ProblemModel();
		$data['numberOfProblems'] = $problemModel->countAll();

		$userModel = new UserModel();
		$data['numberOfUsers'] = $userModel->countAll();
		
		echo view('template/header', $data);
		echo view('pages/home');
		echo view('template/footer');
	}

	public function sitemap () {
		$examModel = new ExamModel();
		$data['exams'] = $examModel->findAll();

		$this->response->setHeader('Content-Type', 'text/xml;charset=iso-8859-1');
        echo view("template/sitemap", $data);
	}

	public function transliterate () {
		$data['TITLE'] = "Пресловљавање";

		echo view('template/header', $data);
		echo view('pages/transliterate');
		echo view('template/footer');
	}

	public function about()
	{
		$data['TITLE'] = "О пројекту";
		echo view('template/header', $data);
		echo view('pages/about');
		echo view('template/footer');
	}

	public function manual()
	{
		$data['TITLE'] = "Упутство";
		echo view('template/header', $data);
		echo view('pages/manual');
		echo view('template/footer');
	}
}
