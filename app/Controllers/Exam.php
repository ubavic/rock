<?php namespace App\Controllers;

use App\Models\ExamModel;
use App\Models\ProblemModel;
use App\Models\SubjectModel;


class Exam extends BaseController
{
	public function index()
	{
		$data['TITLE'] = "Рокови";

		$model = new ExamModel();
		$data["exams"] = $model->findAll();

		$subjectsModel = new SubjectModel();
		$data['subjectsList'] = $subjectsModel->getAllSubjectsOptionList();

		echo view('template/header', $data);
		echo view('exams/list');
		echo view('template/footer');
	}


	public function getExams($subject) {
		if ($subject == NULL)
			$subject = 1;

		$subject = intval($subject);
		$examModel = new ExamModel();
		$data['exams'] = $examModel->where('subject', $subject)->findAll();
		echo view('exams/examListTemplate', $data);
	}

	public function view($ID = 0)
	{
		$data['TITLE'] = "Прегледај рок";

		$examModel = new ExamModel();
		$data["exam"] = $examModel->find($ID);

		$problemsModel = new ProblemModel();
		$data["problems"] = $problemsModel->getProblems($ID);

		echo view('template/header', $data);
		echo view('exams/view');
		echo view('template/footer');
	}

	public function new() {
		$data['TITLE'] = "Нови рок";

		helper('form');
		$model = new ExamModel();

		$subjectsModel = new SubjectModel();
		$data['subjectsList'] = $subjectsModel->getAllSubjectsOptionList();

		if($this->request->getMethod() == 'post') {
			$rules = [
				'duration' => 'required',
				'date' => 'required'
			];

			if (!$this->validate($rules)) {
				$data['exam'] = (object) [
					'subject' => NULL,
					'date' => NULL,
					'duration' => NULL,
					'note' => NULL,
					'additional_note' => NULL,
					'type' => NULL,
					'modules' => NULL,
					'modules_array' => [0, 0, 0, 0, 0, 0, 0]
				];

				$data['validation'] = $this->validator;
				echo view('template/header', $data);
				echo view('exams/new');
				echo view('template/footer');
			} else {
				$model -> save([
					'subject' => $this->request->getVar('subject'),
					'date' => $this->request->getVar('date'),
					'duration' => $this->request->getVar('duration'),
					'note' => $this->request->getVar('note'),
					'additional_note' => $this->request->getVar('additional_note'),
					'type' => empty($this->request->getVar('type')) ? 0 : 1,
					'modules' => $model->getModulesInt($this->request->getVar('module')),
					'created_by' => session()->get('id'),
					'updated_by' => session()->get('id'),
					]
				);

				$id = $model->where('created_by', session()->get('id'))->get()->getLastRow()->id;

				$problemModel = new ProblemModel();
				$problems = $this->request->getVar('problems');

				foreach ($problems as $problem) {
					$problemModel -> save([
						'exam' => $id,
						'text' => $problem
					]);
				}

				return redirect()->to('/exam/view/' . $id);
			}
		
		} else {
			$data['exam'] = (object) [
				'subject' => NULL,
				'date' => NULL,
				'duration' => NULL,
				'note' => NULL,
				'additional_note' => NULL,
				'type' => NULL,
				'modules' => NULL,
				'modules_array' => [0, 0, 0, 0, 0, 0, 0]
			];

			echo view('template/header', $data);
			echo view('exams/new');
			echo view('template/footer');
		}
	}


	public function edit($ID = false) {

		if ($ID == false) {
			return redirect()->to('/exam');
		}

		helper('form');
		$model = new ExamModel();

		$data['TITLE'] = "Измени рок";
		$data['exam'] = $model->find($ID);

		$subjectsModel = new SubjectModel();
		$data['subjectsList'] = $subjectsModel->getAllSubjectsOptionList();

		if (!$this->validate([
			'duration' => 'required',
			'date' => 'required'
		])) {
			echo view('template/header', $data);
			echo view('exams/new');
			echo view('template/footer');
		} else {
			$model -> save([
				'id' => $ID,
				'subject_id' => $this->request->getVar('subject_id'),
				'subject' => $this->request->getVar('subject'),
				'date' => $this->request->getVar('date'),
				'duration' => $this->request->getVar('duration'),
				'note' => $this->request->getVar('note'),
				'additional_note' => $this->request->getVar('additional_note'),
				'type' => empty($this->request->getVar('type')) ? 0 : 1,
				'modules' => $model->getModulesInt($this->request->getVar('module'))
				]
			);

			return redirect()->to('/exam/view/'. $ID);
		}

	}


}
