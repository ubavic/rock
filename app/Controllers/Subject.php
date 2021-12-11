<?php namespace App\Controllers;

use App\Models\SubjectModel;

class Subject extends BaseController
{
	private $errors = [
		'name' => [
			'required' => 'Име је обавезно.',
			'is_unique' => 'Име већ постоји.',
			'min_length' => 'Име мора да садржи барем 3 карактера.',
			'max_length' => 'Име може да садржи највише 255 карактера.'
		],
		'code' => [
			'required' => 'Код је обавезан.',
			'is_unique' => 'Код већ постоји.',
			'min_length' => 'Код мора да садржи барем 3 карактера.',
			'max_length' => 'Код може да садржи највише 255 карактера.'
		]
	];

	public function all()
	{
		$data['TITLE'] = 'Сви предмети';

		$subjectModel = new SubjectModel();
		$data['subjects'] = $subjectModel->findAll();;

		echo view('subject/all', $data);
	}


	public function new()
	{
		$data['subject'] =  (object) [
			'name' => '',
			'code' => ''
		];
		$data['TITLE'] = 'Додај нови рок';
		$data['new'] = true;

		echo view('subject/edit', $data);
	}


	public function newPost()
	{
		helper(['form']);
		$rules = [
			'name'  => 'required|is_unique[subjects.name]|min_length[3]|max_length[255]',
			'code'  => 'required|is_unique[subjects.code]|min_length[3]|max_length[6]',
		];

		if ($this->validate($rules, $this->errors)) {
			$subject = [
				'name' => $this->request->getVar('name'),
				'code' => $this->request->getVar('code'),
			];
			$subjectModel = new SubjectModel();
			$subjectModel->insert($subject);

			session()->setFlashdata('success', 'Предмет је додат.');
			return redirect()->to('/subject');
		} else {
			session()->setFlashdata('error', $this->validator->listErrors());
			return redirect()->to('/subject/new');
		}
	}


	public function subject($id)
	{
		if ($id === null)
			return redirect()->to('/subject');

		$subjectModel = new SubjectModel();
		$subject = $subjectModel->find($id);

		if ($subject === null)
			return redirect()->to('/subject');

		$data['TITLE'] = $subject->name;
		$data['subject'] = $subject;
		$data['new'] = false;

		echo view('subject/edit', $data);
	}

	public function subjectPost($id)
	{
		if ($id === null)
			return redirect()->to('/subject');

		helper(['form']);
		$rules = [
			'name'  => "required|is_unique[subjects.name,id,{$id}]|min_length[3]|max_length[255]",
			'code'  => "required|is_unique[subjects.code,id,{$id}]|min_length[3]|max_length[6]",
		];

		if ($this->validate($rules, $this->errors)) {
			$subject = [
				'name' => $this->request->getVar('name'),
				'code' => $this->request->getVar('code'),
			];
			$subjectModel = new SubjectModel();
			$subjectModel->update($id, $subject);

			session()->setFlashdata('success', 'Предмет је измењен.');
			return redirect()->to('/subject');
		} else {
			session()->setFlashdata('error', $this->validator->listErrors());
			return redirect()->to('/subject/' . $id);
		}
	}

	
	public function delete($id)
	{
		if ($id === null)
			return redirect()->to('/subject');

		$subjectModel = new SubjectModel();
		$subjectModel->delete($id);
		session()->setFlashdata('success', 'Предмет је обрисан.');
		return redirect()->to('/subject');
	}
}
