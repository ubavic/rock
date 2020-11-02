<?php namespace App\Controllers;

use App\Models\ExamModel;
use App\Models\ProblemModel;
use App\Models\SubjectModel;
use App\Models\UserModel;

class Exam extends BaseController
{
	public function index()
	{
		$data['TITLE'] = "Рокови";

		$model = new ExamModel();
		$data["exams"] = $model->findAll();

		$subjectsModel = new SubjectModel();
		$data['subjectsList'] = $subjectsModel->getUsedSubjectsOptionList();

		$userModel = new UserModel();
		if (session()->get('logged') and $userModel->find(session()->get('id'))->can_add)
			$data['can_add'] = 1;
		else
			$data['can_add'] = 0;

		echo view('template/header', $data);
		echo view('exams/list');
		echo view('template/footer');
	}

	public function getExams($subject) {
		if ($subject == NULL)
			$subject = 1;

		$subject = intval($subject);
		$examModel = new ExamModel();
		$data['exams'] = $examModel->where('subject', $subject)->orderBy('date', 'desc')->findAll();
		echo view('exams/examListTemplate', $data);
	}

	public function view($ID = 0){
		$data['TITLE'] = "Прегледај рок";

		$examModel = new ExamModel();
		$data["exam"] = $examModel->find($ID);

		$problemsModel = new ProblemModel();
		$data["problems"] = $problemsModel->getProblems($ID);

		$userModel = new UserModel();
		$data["created_by"] = $userModel->getAbbr($data["exam"]->created_by);
		$data["updated_by"] = $userModel->getAbbr($data["exam"]->updated_by);

		$data['can_edit'] = 0;
		$data['can_delete'] = 0;

		if (session()->get('logged')) {
			if ($userModel->find(session()->get('id'))->can_edit)
				$data['can_edit'] = 1;
			if ($userModel->find(session()->get('id'))->can_delete)
				$data['can_delete'] = 1;
		}

		echo view('template/header', $data);
		echo view('exams/view');
		echo view('template/footer');
	}

	public function new() {
		$data['TITLE'] = "Нови рок";

		helper('form');
		$model = new ExamModel();

		$emptyExam = (object) [
			'subject' => NULL,
			'date' => NULL,
			'duration' => 0,
			'note' => NULL,
			'additional_note' => NULL,
			'type' => NULL,
			'ma' => 0,
			'mi' => 0,
			'ml' => 0,
			'mm' => 0,
			'mp' => 0,
			'mr' => 0,
			'ms' => 0,
		];

		$subjectsModel = new SubjectModel();
		$data['subjectsList'] = $subjectsModel->getAllSubjectsOptionList();

		if($this->request->getMethod() == 'post') {
			$rules = [
				'duration' => 'required',
				'date' => 'required'
			];

			if (!$this->validate($rules)) {
				$data['exam'] = $emptyExam;
				$data['validation'] = $this->validator;
				echo view('template/header', $data);
				echo view('exams/new');
				echo view('template/footer');
			} else {
				$modules = $this->request->getVar('module');
				if($modules == NULL)
					$modules = [];

				$model -> save([
					'subject' => $this->request->getVar('subject'),
					'date' => $this->request->getVar('date'),
					'duration' => $this->request->getVar('duration'),
					'note' => $this->request->getVar('note'),
					'additional_note' => $this->request->getVar('additional_note'),
					'type' => empty($this->request->getVar('type')) ? 0 : 1,
					'created_by' => session()->get('id'),
					'updated_by' => session()->get('id'),
					'ma' => in_array(0, $modules),
					'mi' => in_array(1, $modules),
					'ml' => in_array(2, $modules),
					'mm' => in_array(3, $modules),
					'mp' => in_array(4, $modules),
					'mr' => in_array(5, $modules),
					'ms' => in_array(6, $modules),
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
			$data['exam'] = $emptyExam;

			echo view('template/header', $data);
			echo view('exams/new');
			echo view('template/footer');
		}
	}

	public function edit($id = false) {
		if ($id == false) {
			return redirect()->to('/exam');
		}

		$model = new ExamModel();
		$problemModel = new ProblemModel();
		$dbProblems = $problemModel->where('exam', $id)->findAll();

		if ($this->request->getMethod() == 'post') {
			$modules = $this->request->getVar('module');
			if($modules == NULL)
				$modules = [];

			$model -> save([
				'id' => $id,
				'subject_id' => $this->request->getVar('subject_id'),
				'subject' => $this->request->getVar('subject'),
				'date' => $this->request->getVar('date'),
				'duration' => $this->request->getVar('duration'),
				'note' => $this->request->getVar('note'),
				'additional_note' => $this->request->getVar('additional_note'),
				'type' => empty($this->request->getVar('type')) ? 0 : 1,
				'ma' => in_array(0, $modules),
				'mi' => in_array(1, $modules),
				'ml' => in_array(2, $modules),
				'mm' => in_array(3, $modules),
				'mp' => in_array(4, $modules),
				'mr' => in_array(5, $modules),
				'ms' => in_array(6, $modules),
				]);

			$problems = $this->request->getVar('problems');
			
			for ($i=0; $i < count($problems); $i++) { 
				$problemModel -> save([
					'id'   => $dbProblems[$i]->id,
					'exam' => $id,
					'text' => $problems[$i],
				]);
			}

			return redirect()->to('/exam/view/'. $id);
		} else {	
			helper('form');

			$data['TITLE'] = "Измени рок";
			$data['exam'] = $model->find($id);

			$subjectsModel = new SubjectModel();
			$data['subjectsList'] = $subjectsModel->getAllSubjectsOptionList();

			$data["problems"] = json_encode($dbProblems );

			echo view('template/header', $data);
			echo view('exams/new');
			echo view('template/footer');
		}
	}

	public function delete ($ID) {

		$examModel = new ExamModel();
		
		$examModel->update($ID, ['updated_by' => session()->get('id')]);
		$examModel->delete($ID);

		return redirect()->to('/exam');
	}

}
