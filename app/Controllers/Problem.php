<?php namespace App\Controllers;

use App\Models\ExamModel;

class Problem extends BaseController
{
	public function index()
	{
		return redirect()->to('/exam');
	}

	public function view($ID = 0)
	{
		if ($ID == 0)
			return redirect()->to('/exam');

		$model = new ExamModel();
		$data["exams"] = $model->getExam($ID);
	}

}
