<?php namespace App\Controllers;

use App\Models\ExamModel;
use App\Models\ProblemModel;
use App\Models\SubjectModel;
use App\Models\UserModel;
use App\Models\SavedExamModel;

class Exam extends BaseController
{
	public function index()
	{
		$user_model = new UserModel();
		$subject_model = new SubjectModel();

		$data['TITLE'] = 'Рокови';
		$data['DESCRIPTION'] = 'Списак свих предмета за које постоји постављен рок.';
		$data['subject_list'] = $subject_model->getUsedSubjectCount();

		if (session()->get('logged') and $user_model->find(session()->get('id'))->can_add)
			$data['can_add'] = 1;
		else
			$data['can_add'] = 0;

		echo view('exams/list', $data);
	}

	public function subject($subject_id = 1)
	{
		$exam_model = new ExamModel();
		$user_model = new UserModel();
		$subject_model = new SubjectModel();

		$data['subject'] = $subject_model->find($subject_id);
		$data['TITLE'] = $data['subject']->name;
		$data['DESCRIPTION'] = 'Списак свих рокова из предмета ' . $data['subject']->name . '.';

		$data['exam_table'] = $exam_model->generateTable($exam_model->where('subject', $subject_id)->orderBy('date', 'desc')->findAll());

		if (session()->get('logged') and $user_model->find(session()->get('id'))->can_add)
			$data['can_add'] = 1;
		else
			$data['can_add'] = 0;

		echo view('exams/subject', $data);
	}

	public function view($exam_id = 0)
	{
		$examModel = new ExamModel();
		$exam = $examModel->find($exam_id);

		if (is_null($exam))
		{
			$this->notFound();
			return;
		}

		$data['exam'] = $exam;

		$problemsModel = new ProblemModel();
		$data['problems'] = $problemsModel->getProblems($exam_id);

		$userModel = new UserModel();
		$data['created_by'] = $userModel->getAbbr($exam->created_by);
		$data['updated_by'] = $userModel->getAbbr($exam->updated_by);

		$subject_model = new SubjectModel();
		$data['subject'] = $subject_model->find($exam->subject);

		$data['can_edit'] = 0;
		$data['can_delete'] = 0;
		$data['saved'] = 0;

		if (session()->get('logged'))
		{
			$user_id = session()->get('id');

			if ($userModel->canEditExam($user_id, $exam_id))
				$data['can_edit'] = 1;
			if ($userModel->find($user_id)->can_delete)
				$data['can_delete'] = 1;

			$saved_exam_model = new SavedExamModel();
			$saved_exam = $saved_exam_model->where('user', $user_id)->where('exam', $exam_id)->first();
			if (!is_null($saved_exam))
				$data['saved'] = 1;
		}

		$data['TITLE'] = $exam->subject_name;

		if (isset($exam->date))
			$data['TITLE'] .= (" • " . $exam->date_string);

		if ($exam->type == 0)
			$description = 'Писмени испит из предмета ' . $exam->subject_name;
		else
			$description = 'Колоквијум из предмета ' . $exam->subject_name;

		if(strlen($exam->modules_string) > 2)
			$description .= ' за смерове ' . $exam->modules_string;
		else if (strlen($exam->modules_string) > 0)
			$description .= ' за смер ' . $exam->modules_string;

		if (isset($exam->date))
			$description .= ' одржан ' . $exam->date_string . ' године на Математичком факултету у Београду.';
		else
			$description .= ' одржан на Математичком факултету у Београду.';

		$data['DESCRIPTION'] = $description;

		echo view('exams/view', $data);
	}

	public function new($subject = 1)
	{
		$data['TITLE'] = 'Нови рок';
		$model = new ExamModel();
		$emptyExam = (object) [
			'subject' => intval($subject),
			'date' => NULL,
			'duration' => 0,
			'note' => NULL,
			'type' => NULL,
			'ma' => 0,
			'mi' => 0,
			'ml' => 0,
			'mm' => 0,
			'mp' => 0,
			'mr' => 0,
			'ms' => 0,
		];

		if ($this->request->getMethod() == 'post')
		{
			$modules = $this->request->getVar('module');
			if ($modules == NULL)
				$modules = [];

			$model -> save([
				'subject' => $this->request->getVar('subject'),
				'date' => $this->request->getVar('date'),
				'duration' => $this->request->getVar('duration'),
				'note' => $this->request->getVar('note'),
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
			$points = $this->request->getVar('points');

			for ($i=0; $i < count($problems); $i++)
				$problemModel -> save([
					'exam' => $id,
					'text' => $problems[$i],
					'points' => $points[$i],
				]);

			session()->setFlashdata('success', 'Рок је успешно додат.');

			return redirect()->to('/exam/view/' . $id);
		}
		else
		{
			$data['exam'] = $emptyExam;
			$data["new"] = True;
			
			$subjectsModel = new SubjectModel();
			$data['subjectsList'] = $subjectsModel->getAllSubjectsOptionList($data['exam']->subject);

			echo view('exams/new', $data);
		}
	}

	public function edit($id = false)
	{
		if ($id == false)
			return redirect()->to('/exam');

		$model = new ExamModel();
		$exam = $model->find($id);
		
		if (is_null($exam))
		{
			$this->notFound();
			return;
		}

		$problemModel = new ProblemModel();
		$dbProblems = $problemModel->where('exam', $id)->findAll();

		if ($this->request->getMethod() == 'post')
		{
			$modules = $this->request->getVar('module');
			$problems = $this->request->getVar('problems');
			$points = $this->request->getVar('points');

			if (sizeof($dbProblems) != sizeof($problems))
				return redirect()->to('/exam/edit/'. $id);

			if ($modules == NULL)
				$modules = [];

			$model -> save([
				'id' => $id,
				'subject' => $this->request->getVar('subject'),
				'date' => $this->request->getVar('date'),
				'duration' => $this->request->getVar('duration'),
				'note' => $this->request->getVar('note'),
				'type' => empty($this->request->getVar('type')) ? 0 : 1,
				'updated_by' => session()->get('id'),
				'ma' => in_array(0, $modules),
				'mi' => in_array(1, $modules),
				'ml' => in_array(2, $modules),
				'mm' => in_array(3, $modules),
				'mp' => in_array(4, $modules),
				'mr' => in_array(5, $modules),
				'ms' => in_array(6, $modules),
				'edit_lock' => 0,
				]);
	
			for ($i=0; $i < count($problems); $i++)
			{
				$problemModel -> save([
					'id'   => $dbProblems[$i]->id,
					'exam' => $id,
					'text' => $problems[$i],
					'points' => $points[$i],
				]);
			}

			session()->setFlashdata('success', 'Рок је успешно измењен.');

			return redirect()->to('/exam/view/'. $id);
		}
		else
		{
			helper('form');

			$data['TITLE'] = "Измени рок";
			$data['exam'] = $exam;

			$subjectsModel = new SubjectModel();
			$data['subjectsList'] = $subjectsModel->getAllSubjectsOptionList($exam->subject);

			$data["problems"] = json_encode($dbProblems);
			$data["new"] = False;

			$model -> save([
				'id' => $id,
				'edit_lock' => 1,
				]);

			echo view('exams/new', $data);
		}
	}

	public function delete($ID)
	{
		$examModel = new ExamModel();
		$exam = $examModel->find($ID);

		if (is_null($exam))
		{
			$this->notFound();
			return;
		}

		$subject = $exam->subject;

		$examModel->update($ID, ['updated_by' => session()->get('id')]);
		$examModel->delete($ID);

		session()->setFlashdata('success', 'Рок је успешно обрисан.');

		return redirect()->to('/exam/' . $subject);
	}

	private function notFound()
	{
		$this->response->setStatusCode(404);
		
		$data['TITLE'] = 'Тражени рок није пронађен!';
		$data['DESCRIPTION'] = 'Тражени рок није пронађен!';
		
		echo view('exams/not_found', $data);
	}

	public function saved()
	{
		$data['TITLE'] = 'Сачувани рокови';

		$saved_exam_model = new SavedExamModel();
		$exam_model = new ExamModel();
		
		$saved_exams = $saved_exam_model->userSavedExams(session()->get('id'));
		$data['exam_table'] = $exam_model->generateTable($exam_model->getMetadata(['data' => $saved_exams])['data']);

		echo view('exams/saved', $data);
	}

	public function saveExam($exam_id = NULL)
	{
		if (is_null($exam_id))
			return redirect()->to('/exam');

		$user_id = session()->get('id');
		$exam_model = new SavedExamModel();
		$saved_exam = $exam_model->where('user', $user_id)->where('exam', $exam_id)->first();

		if (is_null($saved_exam))
		{
			$exam_model->insert([
				'exam' => $exam_id,
				'user' => $user_id,
			]);
			session()->setFlashdata('success', 'Рок је додат у <a href="/exam/saved">листу сачуваних рокова</a>.');
		}
		else
		{
			$exam_model->delete($saved_exam->id);
			session()->setFlashdata('success', 'Рок је уклоњен из <a href="/exam/saved">листе сачуваних рокова</a>.');
		}

		return redirect()->back();
	}
}