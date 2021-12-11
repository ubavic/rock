<?php namespace App\Models;

use CodeIgniter\Model;

class ProblemModel extends Model
{
	protected $table = 'problems';
	protected $allowedFields = ['exam', 'text', 'points'];
	protected $useTimestamps = false;
	protected $useSoftDeletes = false;
	protected $returnType = 'object';

	public function getProblems($id)
	{
		return $this->where('exam', $id)->get()->getResult();
	}

	public function getRandomProblems($subject, $limit)
	{
		return $this
			->select('text, subject, 0 AS points')
			->join('exams', 'problems.exam = exams.id', 'left')
			->where('subject', $subject)
			->orderBy('subject', 'random')
			->limit($limit)
			->get()->getResult();
	}

	public function getTex($id)
	{
		$tex = $this->find($id);

		$tex = str_replace('<p>', "\n", $tex->text);
		$tex = str_replace('</p>', "\n", $tex);
		$tex = str_replace('<li>', "\\item\\ ", $tex);
		$tex = str_replace('</li>', "", $tex);
		$tex = str_replace('<ol>', "\\begin{enumerate}", $tex);
		$tex = str_replace('</ol>', "\\end{enumerate}\n", $tex);
		$tex = str_replace('<ul>', "\\begin{itemize}\n", $tex);
		$tex = str_replace('</ul>', "\\end{itemize}\n", $tex);
		$tex = str_replace('<em>', "\\textit{", $tex);
		$tex = str_replace('</em>', "}", $tex);
		$tex = str_replace('<i>', "\\textit{", $tex);
		$tex = str_replace('</i>', "}", $tex);
		$tex = str_replace('<strong>', "\\textbf{", $tex);
		$tex = str_replace('</strong>', "}", $tex);
		$tex = str_replace("<math-inline>", "\\)", $tex);
		$tex = str_replace("</math-inline>", "\\)", $tex);
		$tex = str_replace("<math-display>", "\\]", $tex);
		$tex = str_replace("</math-display>", "\\]", $tex);
		$tex = str_replace(".\\)", "\\).", $tex);
		$tex = str_replace(",\\)", "\\),", $tex);
		$tex = str_replace("\\]", "\\]\n", $tex);
		$tex = str_replace("\\[", "\n\\[", $tex);
		$tex = str_replace("\\gt", ">", $tex);
		$tex = str_replace("\\lt", "<", $tex);

		return trim($tex);
	}
}
