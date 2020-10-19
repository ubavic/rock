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
		$data['exams'] = $examModel->getLastTenExams();
		$data['numberOfExams'] = $examModel->countAll();

		$subjectModel = new SubjectModel();
		$data['numberOfSubjects'] = $subjectModel->countAll();

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
		$data['exams'] = $examModel->getExams();

		$this->response->setHeader('Content-Type', 'text/xml;charset=iso-8859-1');
        echo view("template/sitemap", $data);
	}






}
